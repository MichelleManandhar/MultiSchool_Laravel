<template>
  <div class="dashbody" v-show="this.isActiveComputed">
    <ag-grid-vue
      class="ag-theme-blue"
      :columnDefs="columnDefs"
      :rowData="rowData"
      rowSelection="multiple"
      @grid-ready="onGridReady"
      @rowValueChanged="rowValueChanged"
      :editType="editType"
      :enterMovesDownAfterEdit="true"
      :enterMovesDown="true"
    ></ag-grid-vue>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import axios from "axios";

export default {
  name: "Attendance",
  data() {
    return {
      isActive: false,
      columnDefs: null,
      rowData: null,
      editType: null,
      gridApi: null
    };
  },
  props: {
    name: { required: true },
    isselected: { default: false },
    classId: { required: true },
    sectionId: { required: true }
  },

  computed: {
    href() {
      return "#" + this.name.toLowerCase().replace(/ /g, "-");
    },
    isActiveComputed() {
      return this.isActive;
    }
  },
  mounted() {
    this.isActive = this.isselected;
  },
  components: {
    "ag-grid-vue": AgGridVue
  },
  beforeMount() {
    this.columnDefs = [
      {
        headerName: "attendance_id",
        field: "id",
        width: 100,
        hide: true,
        suppressToolPanel: true
      },
      {
        headerName: "student_id",
        field: "student_id",
        width: 100,
        hide: true,
        suppressToolPanel: true
      },
      {
        headerName: "Rollno",
        field: "roll_no",
        sortable: true,
        filter: true,
        width: 200
      },
      {
        headerName: "Student_name",
        field: "name",
        sortable: true,
        filter: true,
        width: 200
      },
      {
        headerName: "School Days",
        field: "school_days",
        sortable: true,
        filter: true,
        width: 200,
        editable: true
      },
      {
        headerName: "Present Days",
        field: "present_days",
        sortable: true,
        filter: true,
        width: 200,
        editable: true
      },
      {
        headerName: "Absent Days",
        field: "absent_days",
        sortable: true,
        filter: true,
        width: 200,
        valueGetter: function(params){
          return params.data.school_days - params.data.present_days
        }
      }
    ];
    this.editType = "fullRow";
    this.getAttendanceData();
  },
  methods: {
    getAttendanceData() {
      axios
        .get("attendance/" + this.sectionId)
        .then(rowData => (this.rowData = rowData.data.attendance));
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;

        this.gridApi.showLoadingOverlay();
    },
    getSelectedRows() {
      const selectedNodes = this.gridApi.getSelectedRows();
    },
    rowValueChanged: function(event) {
      if (event.data.id != null) {
        axios
          .post(`/attendance/${this.sectionId}/edit/${event.data.id}`, {
            student_id: event.data.student_id,
            school_days: event.data.school_days,
            present_days: event.data.present_days
          })
          .then(data => {
            this.$noty.success("Attendance updated successfully!");
          }).catch(e => {
            this.$noty.error("Error while updating attendance!");
          });
      } else {
        axios
          .post(`attendance/${this.sectionId}/store`, {
            student_id: event.data.student_id,
            school_days: event.data.school_days,
            present_days: event.data.present_days
          })
          .then(res => {
            this.$noty.success("Attendance saved successfully!");
            event.node.setData(res.data.subject_data);
          }).catch(e => {
            this.$noty.error("Error while storing attendance!");
          });
      }
    }
  },
  mounted() {
    
  },
  watch: {
    sectionId: function() {
      this.getAttendanceData();
    },
    isActive: function() {
      if (this.isActive) {
        this.getAttendanceData();
      }
    }
  }
};
</script>

<style scoped>
.dashbody {
  margin: 1px 10px 10px 10px;
  height: 100vh;
  overflow-y: hidden;
  border: thin #abdde5;
  box-shadow: 2px 2px 2px 2px #abdde5;
}

.ag-theme-blue {
  width: 1000px;
  height: 425px;
  margin-left: 30px;
  margin-top: 30px;
}
</style>
