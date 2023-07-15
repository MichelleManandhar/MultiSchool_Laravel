<template>
  <div class="dashbody" v-show="this.isActiveComputed">
    <div class="button-area">
      <button class="btn btn-primary" v-on:click="onAddRow">Add Row</button>
    </div>
    <ag-grid-vue
      enctype="multipart/form-data"
      class="ag-theme-blue"
      :columnDefs="columnDefs"
      :rowData="rowData"
      :columnTypes="columnTypes"
      @grid-ready="onGridReady"
      @rowValueChanged="rowValueChanged"
      :editType="editType"
      rowSelection="multiple"
      :enterMovesDownAfterEdit="true"
      :enterMovesDown="true"
      :frameworkComponents="frameworkComponents"
    ></ag-grid-vue>
  </div>
</template>

<script>
import axios from "axios";
import { AgGridVue } from "ag-grid-vue";
import ChildMessageRenderer from "./custom/customMessageRenderer.js";
import actionRenderer from "./custom/actionRenderer.js";

export default {
  name: "Student",
  props: {
    name: { required: true },
    isselected: { default: false },
    classId: { required: true },
    sectionId: { required: true }
  },
  data() {
    return {
      isActive: false,
      columnDefs: null,
      rowData: null,
      editType: null,
      loader: false,
      columnTypes: null,
      frameworkComponents: null,
      findImage: ""
    };
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
    eventBus.$on("image_upload", this.setImage);
    eventBus.$on("store-student", this.getStudentData);
  },
  components: {
    "ag-grid-vue": AgGridVue
  },
  created() {
    eventBus.$on("update-student", this.getStudentData);
    eventBus.$on("added-sponsor", this.getSponsorsData);
    eventBus.$on("imageupload", this.changeImage);
    this.frameworkComponents = {
      childMessageRenderer: ChildMessageRenderer,
      actionRenderer: actionRenderer
    };
    this.columnTypes = {
      nonEditableColumn: { editable: false },
      dateColumn: {
        filter: "agDateColumnFilter",
        filterParams: {
          comparator: (filterLocalDateAtMidnight, cellValue) => {
            var dateParts = cellValue.split("-");
            var day = Number(dateParts[0]);
            var month = Number(dateParts[1]) - 1;
            var year = Number(dateParts[2]);
            var cellDate = new Date(year, month, day);
            if (cellDate < filterLocalDateAtMidnight) {
              return -1;
            } else if (cellDate > filterLocalDateAtMidnight) {
              return 1;
            } else {
              return 0;
            }
          }
        }
      }
    };
  },
  async beforeMount() {
    let sponsors = axios.get("/sponsor");
    [sponsors] = await Promise.all([sponsors]);
    this.sponsors = sponsors.data.sponsors;
    this.columnDefs = [
      {
        headerName: "Student Id",
        field: "id",
        sortable: true,
        filter: true,
        hide: true,
        suppressToolPanel: true
      },
      {
        headerName: "Roll no",
        field: "roll_no",
        sortable: true,
        editable: true
      },
      {
        headerName: "First Name",
        field: "fname",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Middle Name",
        field: "mname",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Last Name",
        field: "lname",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "DOB (yyyy-mm-dd A.D)",
        field: "DOB",
        sortable: true,
        type: ["dateColumn", "nonEditableColumn"],
        filter: true,
        editable: true
      },
      {
        headerName: "Mobile No.",
        field: "mobile_no",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Father's Name",
        field: "fathers_name",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Father's contact",
        field: "fathers_contact",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Mother's name",
        field: "mothers_name",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Mother's contact",
        field: "mothers_contact",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Permanent address",
        field: "permanent_address",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Temporary address",
        field: "temporary_address",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Parent name",
        field: "parent_name",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Sponsor",
        field: "sponsor_name",
        sortable: true,
        filter: true,
        editable: true,
        cellEditor: "agSelectCellEditor",
        cellEditorParams: {
          values: this.sponsors.map(sponsor => sponsor.name)
        }
      },
      {
        headerName: "Category",
        field: "category_list",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Uploaded Image",
        field: "image_name",
        sortable: false,
        filter: true,
      },
      {
        headerName: "Identity Image",
        field: "image_name",
        sortable: true,
        cellRenderer: "childMessageRenderer",
        colId: "params",
        filter: true,
      },
      {
      headerName: "Action",
      field: "action",
      sortable: true,
      cellRenderer: "actionRenderer",
      colId: "params",
      filter: true,
        editable: false
      }
    ];
    this.editType = "fullRow";
    this.loader = true;
    axios
      .get("/student/" + this.sectionId)
      .then(result => {
        this.rowData = result.data.data;
        this.loader = false;
      })
      .catch(err => {});
  },
  watch: {
    sectionId: function() {
      this.getStudentData();
    }
  },
  methods: {
    onAddRow() {
      this.gridApi.updateRowData({ add: [{}] });
    },

    getSelectedRows() {
      axios
        .post("/delete/students", {
          students: this.gridApi.getSelectedRows()
        })
        .then(res => {
          this.getStudentData();
        })
        .catch(err => {
          alert(err);
        });
    },
    getStudentData() {
      this.loader = true;
      this.gridApi.showLoadingOverlay();
      axios.get("/student/" + this.sectionId).then(result => {
        this.loader = false;
        this.rowData = result.data.data;
      });
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
    },
    rowValueChanged(event) {
      if (event.data.id != null) {
        axios
          .post(
            "student/edit/" +
              this.classId +
              "/" +
              this.sectionId +
              "/" +
              event.data.id,
            {
              fname: event.data.fname,
              mname: event.data.mname,
              lname: event.data.lname,
              fathers_name: event.data.fathers_name,
              DOB: event.data.DOB,
              mobile_no: event.data.mobile_no,
              fathers_contact: event.data.fathers_contact,
              mothers_name: event.data.mothers_name,
              mothers_contact: event.data.mothers_contact,
              permanent_address: event.data.permanent_address,
              temporary_address: event.data.temporary_address,
              roll_no: event.data.roll_no,
              parent_name: event.data.parent_name,
              sponsor_id: this.sponsors.find(
                sponsor => sponsor.name === event.data.sponsor_name
              )["id"]
            }
          )
          .then(data => {
            eventBus.$emit('update-student');
            this.$noty.success("Student updated successfully");
            axios.post('/studentHistory/'+ event.data.id, {event:'StudentUpdated'})
            .then(res =>{
            this.$noty.success("Student updated information recorded");
          })
            eventBus.$emit("update-id-card");

          })
          .catch(e => {
            this.$noty.error("Error while updating student");
          });
      } else {
        axios
          .post(
            "student/store/" + this.classId + "/" + this.sectionId,
            this.getData(event)
          )
          .then(data => {
            eventBus.$emit('update-student');
            event.node.setData(data.data.data);
            this.$noty.success("Student added successfully");
            this.onAddRow();
            axios.post('/studentHistory/'+ data.data.data.id, {event:'StudentAdded'})
            .then(res =>{
           this.$noty.success("Student added information recorded");
          })
           event.node.setData(data.data.data);
          this.onAddRow();
            eventBus.$emit("store-student");


          })
          .catch(e => {
            this.$noty.error("Error while adding student");
          });
      }
    },
    getData(event) {
      let data = new FormData();
      data.append(`fname`, event.data.fname);
      data.append(
        "mname",
        event.data.mname === undefined ? "" : event.data.mname
      );
      data.append("lname", event.data.lname);
      data.append(
        "fathers_name",
        event.data.fathers_name === undefined ? "" : event.data.fathers_name
      );
      data.append("DOB", event.data.DOB === undefined ? "" : event.data.DOB);
      data.append(
        "mobile_no",
        event.data.mobile_no === undefined ? "" : event.data.mobile_no
      );
      data.append(
        "fathers_contact",
        event.data.fathers_contact === undefined
          ? ""
          : event.data.fathers_contact
      );
      data.append(
        "mothers_name",
        event.data.mothers_name === undefined ? "" : event.data.mothers_name
      );
      data.append(
        "mothers_contact",
        event.data.mothers_contact === undefined
          ? ""
          : event.data.mothers_contact
      );
      data.append(
        "permanent_address",
        event.data.permanent_address === undefined
          ? ""
          : event.data.permanent_address
      );
      data.append(
        "temporary_address",
        event.data.temporary_address === undefined
          ? ""
          : event.data.temporary_address
      );
      data.append(
        "roll_no",
        event.data.roll_no === undefined ? "" : event.data.roll_no
      );
      data.append(
        "parent_name",
        event.data.parent_name === undefined ? "" : event.data.parent_name
      );
      data.append(
        "sponsor_id",
        this.sponsors.find(sponsor => sponsor.name === event.data.sponsor_name)[
          "id"
        ]
      );
      if (this.findImage) {
        data.append("image", this.findImage);
        this.findImage = {};
      }
      return data;
    },
    changeImage(params) {
      this.findImage = params.image;
    }
  }
};
</script>

<style>
.dashbody {
  margin: 1px 10px 10px 10px;
  height: 100vh;
  overflow-y: hidden;
}

.ag-theme-blue {
  display: flex;
  width: 100%;
  height: 425px;
}

.dashbody::after {
  content: " ";
  position: absolute;
  bottom: 0;
}
.action {
  font-size: 0.75rem;
  line-height: 1.5;
  border-radius: 0.2rem;
}

.ag-root-wrapper {
  width: 100% !important;
}
.loader {
  position: absolute;
  background: rgba(0, 0, 0, 0.5);
  height: 100vh;
  width: 100%;
  z-index: 999;
  display: flex;
  justify-content: center;
  align-items: center;
}
.loader loader-item {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.loader i {
  font-size: 10vh;
  color: white;
}
.loader span {
  font-size: 24px;
  color: white;
}
</style>
