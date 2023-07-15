<template>
  <modal name="teacherModal" width="60%" height="60%">
    <div class="modal-content">
      <div class="modal-header">
        <div class="header-text">Teacher list</div>
        <div class="add-button">
          <button @click="addTeacher()">Add Teacher</button>
        </div>
      </div>
      <ag-grid-vue
        class="ag-theme-blue"
        :columnDefs="columnDefs"
        :rowData="rowData"
        :columnTypes="columnTypes"
        @grid-ready="onGridReady"
        rowSelection="multiple"
        style="overflow:'scroll'"
        :editType="editType"
        @rowValueChanged="rowValueChanged"
        :frameworkComponents="frameworkComponents"
      ></ag-grid-vue>
    </div>
  </modal>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import axios from "axios";
import teacherActionRender from "../tab-component/custom/teacherActionRender.js";
import childMessageRenderer from "../tab-component/custom/customTeacherMsgRenderer.js";
export default {
  name: "TeacherModal",
  components: {
    "ag-grid-vue": AgGridVue
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
      findImage : '', 
      };
  },
  isActiveComputed() {
      return this.isActive;
  },
  mounted() {
    this.isActive = this.isselected;
  },
  created(){
      eventBus.$on('update-teacher',this.getTeacherData);
      eventBus.$on('added-teacher',this.getTeacherData);
      eventBus.$on('delete-teacher',this.getTeacherData);
      eventBus.$on('imageupload',this.changeImage)
    },
  beforeMount() {
    this.columnDefs = [
      {
        headerName: "S.N",
          cellRenderer : function (params) {
              return parseInt(params.node.id) + 1;
          },
        sortable: true,
        filter: true,
        width: 200
      },
      {
        headerName: "Teacher name",
        field: "name",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      {
        headerName: "Designation",
        field: "designation",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      {
        headerName: "Contact Number",
        field: "contact_no",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      {
        headerName: "Address",
        field: "address",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      {
        headerName: "DOB (yyyy-mm-dd A.D)",
        field: "DOB",
        sortable: true,
        type: ["dateColumn", "nonEditableColumn"],
        filter: true,
        editable: true,
      },
      {
        headerName: "Uploaded Image",
        field: "image_name",
        sortable: false,
        filter: false,
        editable: false
      },
      {
        headerName: "Identity Image",
        field: "image_name",
        sortable: true,
        cellRenderer: "childMessageRenderer",
        colId: "params",
        filter: true,
        editable: false
      },
      { 
        headerName: "Action",
        field : "action",
        cellRenderer: "teacherActionRender",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
        },
    ];
      this.frameworkComponents = {
          teacherActionRender : teacherActionRender,
          childMessageRenderer : childMessageRenderer
      },
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
    this.editType = "fullRow";
    this.getTeacherData();
  },
    methods: {
    getTeacherData() {
      axios.get("/teachers/").then(resp => {
        this.rowData = resp.data.teacher;
      });
    },
    addTeacher() {
      this.gridApi.updateRowData({ add: [{}] });
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
    },

    rowValueChanged(event) {
      if (event.data.id != null) {
        axios
          .post(`/teacher/edit/${event.data.id}`, {
            name: event.data.name,
            designation: event.data.designation,
            contact_no: event.data.contact_no,
            address: event.data.address,
            DOB: event.data.DOB
          })
          .then(data => {
            this.$noty.success("Teacher has been updated.");
          }).catch(err => {
                        this.$noty.error("Error in updating teacher");
 
                    });  
      } else {
        axios
          .post("/teacher/store", this.getData(event))
          .then(res => {
            eventBus.$emit('added-teacher');
            this.$noty.success("Teacher has been added.");
            event.node.setData(res.data.teacher);
          }).catch(err => {
                        this.$noty.error("Error in adding teacher");
                    });
      }
    },
    getData(event){
      let data = new FormData()
        data.append('name', event.data.name)
        data.append('designation', event.data.designation)
        data.append('contact_no', event.data.contact_no)
        data.append('address', event.data.address)
        data.append('DOB', event.data.DOB)
        if(this.findImage){
              data.append('image',this.findImage)
              this.findImage = {}
          }
          return data
      },
      changeImage(params){
        this.findImage = params.image
      }
    }
};
</script>


<style scoped lang = "scss">
.ag-theme-blue {
  display: flex;
  width: 800px;
  height: 30vh;
  margin-left: 30px;
  margin-top: 30px;
}
.modal-content {
  height: 100%;
  width: 100%;
  padding: 10px;
}
  .modal-header {
    font-size: 20px;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
  }
  button {
    background-color: rgb(0, 136, 199);
    color: white;
    padding: 10px;
    box-sizing: border-box;
  }
  .action{
  font-size: 0.75rem;
  line-height: 1.5;
  border-radius: 0.2rem;
}
</style>