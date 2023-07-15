<template>
  <div class="subjectCreate">
    <button class="btn-add" v-on:click="onAddRow">Add Row</button>
    <button @click="getSelectedRows()">Get Selected Rows</button>
    <ag-grid-vue
      class="ag-theme-blue"
      :columnDefs="columnDefs"
      :rowData="rowData"
      @grid-ready="onGridReady"
      @rowValueChanged="rowValueChanged"
      :editType="editType"
      rowSelection="multiple"
    ></ag-grid-vue>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import axios from "axios";

export default {
  name: "AddSubject",
  data() {
    return {
      isActive: false,
      columnDefs: null,
      rowData: null,
      editType: null
    };
  },
  components: {
    "ag-grid-vue": AgGridVue
  },
  beforeMount() {
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
        editable: true
      },
      {
        headerName: "Created At",
        field: "created_at",
        sortable: true,
        editable: false
      }
    ];
    this.editType = "fullRow";

    this.getSubjectsData();
  },
  methods: {
    onAddRow() {
      for (var i = 0; i <= 20; i++) {
        this.gridApi.updateRowData({ add: [{}] });
      }
    },
    getSubjectsData() {
      axios.get("http://127.0.0.1:8000/api/getAllSubject/").then(result => {
        this.rowData = result.data.data;
      });
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
    },
    getSelectedRows() {
      const selectedNodes = this.gridApi.getSelectedRows();
    },
    onCellEditingStarted: function(event) {},
    rowValueChanged: function(event) {
      if (event.data.id != null) {
        axios
          .post("edit-base-subject" + "/" + event.data.id, {
            name: event.data.name
          })
          .then(data => {});
      } else {
        axios
          .post("/store-base-subject", {
            name: event.data.name
          })
          .then(data => {
            event.node.setData(data.data.subject);
          });
      }
    }
  }
};
</script>

<style scoped>
.subjectCreate {
  flex: 1;
}

.ag-theme-blue {
 
}
</style>