<template>
  <modal name="examModal" width="60%" height="60%">
    <div class="modal-content">
      <div class="modal-header">
        <div class="header-text">Exam list</div>
        <div class="add-button">
          <button @click="addExam()">Add Exam</button>
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
import axios from "axios";
import { AgGridVue } from "ag-grid-vue";
import examActionRenderer from "../tab-component/custom/examActionRenderer.js";
export default {
  name: "ExamModal",
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
        headerName: "Exam Name",
        field: "name",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      { 
        headerName: "Action",
        field : "action",
        cellRenderer: "examActionRenderer",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
        }
    ];
    this.frameworkComponents = {
          examActionRenderer : examActionRenderer
      },
    this.editType = "fullRow";

    this.getExamData();
  },created(){
    eventBus.$on('added-exam',this.getExamData)
    eventBus.$on('update-exam',this.getExamData)
  },
  methods: {
    getExamData() {
      axios.get("/exam").then(res => {
        this.rowData = res.data.exams;
      });
    },
    addExam() {
      this.gridApi.updateRowData({ add: [{}] });
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
    },

    rowValueChanged(event) {
      if (event.data.id != null) {
        axios
          .post(`/exam/edit/${event.data.id}`, {
            name: event.data.name
          })
          .then(data => {
            this.$noty.success('Exam type edited.')
          }).catch(e => {
            this.$noty.error("Error while updating exam!");
          });
      } else {
        axios
          .post("/exam/store", {
            name: event.data.name,
          })
          .then(res => {
            eventBus.$emit('added-exam');
            this.$noty.success('Exam type added.')
            event.node.setData(res.data.exam);
          }).catch(e => {
            this.$noty.error("Error while adding exam!");
          });
      }
    }
  }
};
</script>


<style scoped lang = "scss">
.ag-theme-blue {
  display: flex;
  width: 60%;
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