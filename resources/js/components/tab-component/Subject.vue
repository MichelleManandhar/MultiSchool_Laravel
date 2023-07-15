<template>
  <div class="dashbody" v-show="this.isActiveComputed">
    <div class="button-area">
      <button class="btn btn-add-row" v-on:click="onAddRow">Add Row</button>
      <button class="btn btn-delete" @click="getSelectedRows">Delete Selected Rows</button>
    </div>
    <ag-grid-vue
      class="ag-theme-blue"
      :columnDefs="columnDefs"
      :rowData="rowData"
      @grid-ready="onGridReady"
      @rowValueChanged="rowValueChanged"
      :editType="editType"
      rowSelection="multiple"
      :enterMovesDownAfterEdit="true"
      :enterMovesDown="true"
    ></ag-grid-vue>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import axios from "axios";
export default {
  name: "Subject",
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
  data() {
    return {
      isActive: false,
      columnDefs: null,
      rowData: null,
        gridColumnApi: null,
      editType: null
    };
  },
  components: {
    "ag-grid-vue": AgGridVue
  },

  async beforeMount() {
    let subjects = axios.get("/getAllSubject");
    let teachers = axios.get("/teachers");
    [subjects, teachers] = await Promise.all([subjects, teachers]);
    this.subjects = subjects.data.subjects;
    this.teachers = teachers.data.teacher;

    this.columnDefs = [
      {
        headerName: "Id",
        field: "id",
        sortable: true,
        filter: true,
        editable: false
      },
      {
        headerName: "Subject Name",
        field: "name",
        sortable: true,
        filter: true,
        editable: true,
        cellEditor: "agSelectCellEditor",
        cellEditorParams: {
          values: this.subjects.map(sub => sub.name)
        }
      },
      {
        headerName: "Subject Code",
        field: "code",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Teacher",
        field: "teacher",
        sortable: true,
        filter: true,
        editable: true,
        cellEditor: "agSelectCellEditor",
        cellEditorParams: {
          values: this.teachers.map(teacher => teacher.name),
          useFormatter: true
        }
      }
    ];
    this.editType = "fullRow";
    this.getSubjectsData();
  },
  methods: {
    onAddRow() {
      this.gridApi.updateRowData({ add: [{}] });
    },
    getSelectedRows() {
      axios
        .post("/delete/section_subject", {
          subjects: this.gridApi.getSelectedRows()
        })
        .then(res => {
          this.getSubjectsData();
        });
    },
    getSubjectsData() {
      axios.get(`sectionsubject/${this.sectionId}`).then(res => {
        this.rowData = [...res.data.subject_data, [{}]];
      });
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
    },
    onCellEditingStarted: function(event) {
    },
    rowValueChanged: function(event) {
      if (event.data.id != null) {
        axios
          .post(`/sectionsubject/${this.sectionId}/edit/${event.data.id}`, {
            subject_id: this.subjects.find(
              subject => subject.name === event.data.name
            )["id"],
            subject_code: event.data.code,
            teacher_id: this.teachers.find(
              teacher => teacher.name === event.data.teacher
            )["id"]
          })
          .then(data => {
            this.$noty.success("Subject edited successfully");
            event.node.setData(data.data.subject_data);
          })
          .catch(e => {
            this.$noty.error("Error while editing subject");
          });
      } else {
        axios
          .post(`sectionsubject/${this.sectionId}/store`, {
            subject_id: this.subjects.find(
              subject => subject.name === event.data.name
            )["id"],
            subject_code: event.data.code,
            teacher_id: this.teachers.find(
              teacher => teacher.name === event.data.teacher
            )["id"]
          })
          .then(res => {
            this.$noty.success("Subject added successfully");
            event.node.setData(res.data.subject_data);
            this.onAddRow();
          })
          .catch(err => {
            this.$noty.error("Error while adding subject");
          });
      }
    }
  },
  watch: {
    sectionId: function() {
      this.getSubjectsData();
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
  width: 800px;
  height: 425px;
  margin-left: 30px;
  margin-top: 30px;
}

.btn-add {
  height: 30px;
  width: 80px;
  background-color: #005cbf;
  color: #f5f5f5;
  border-radius: 4px;
  margin-top: 30px;
}
</style>