<template>
  <modal name="subjectModal" width="60%" height="60%">
    <div class="modal-content">
      <div class="modal-header">
        <div class="header-text">Subject list</div>
        <div class="add-button">
          <button @click="addSubject()">Add Subject</button>
        </div>
      </div>
      <ag-grid-vue
        class="ag-theme-blue"
        :columnDefs="columnDefs"
        :rowData="rowData"
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
import subjectActionRender from "../tab-component/custom/subjectActionRender.js";
export default {
  name: "SubjectModal",
  components: {
    "ag-grid-vue": AgGridVue
  },
  data() {
    return { isActive: false, columnDefs: null, rowData: null, editType: null };
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
        headerName: "Subject Name",
        field: "name",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },{
            headerName: "Action",
            field : "action",
            cellRenderer: "subjectActionRender",
            sortable: true,
            filter: true,
            editable: true,
            width: 200
        }
        ];
      this.frameworkComponents = {
          subjectActionRender : subjectActionRender
      },
    this.editType = "fullRow";

    this.getSubjectData();
  },
    mounted(){
        eventBus.$on('update-subject', this.getSubjectData)
        eventBus.$on('added-subject', this.getSubjectData)
    },
  methods: {
    getSubjectData() {
      axios.get("/getAllSubject").then(resp => {
        this.rowData = resp.data.subjects;
      });
    },
    addSubject() {
      this.gridApi.updateRowData({ add: [{}] });
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
    },
    rowValueChanged(event) {
      if (event.data.id != null) {
        axios
          .post(`/edit-base-subject/${event.data.id}`, {
            name: event.data.name
          })
          .then(data => {
            this.$noty.success('Subject has be edited.')
          });
      } else {
        axios
          .post("/store-base-subject", {
            name: event.data.name
          })
          .then(res => {
              eventBus.$emit('added-subject');
              this.$noty.success("Subject has been added.");
              event.node.setData(res.data.subject);
          });
      }
    }
  }
};
</script>

<style scoped lang = "scss">
.ag-theme-blue {
  display: flex;
  width: 600;
  height: 30vh;
  margin-left: 30px;
  margin-top: 30px;
}
.modal-content {
  height: 100%;
  width: 100%;
  padding: 10px;
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
}
</style>