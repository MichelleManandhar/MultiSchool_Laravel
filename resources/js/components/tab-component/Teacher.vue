<template>
  <div class="dashbody" v-show="this.isActiveComputed">
    <ag-grid-vue
      class="ag-theme-blue"
      :columnDefs="columnDefs"
      :rowData="rowData"
      :gridOptions="gridOptions"
      rowSelection="multiple"
    ></ag-grid-vue>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import axios from "axios";
export default {
  name: "Teacher",
  props: {
    name: { required: true },
    isselected: { default: false },
    classId: { required: true },
    sectionId: { required: true }
  },
  data() {
    return {
      columnDefs: null,
      rowData: null,
      gridOptions: null,
      gridApi: null,
      isActive: false,
      getRowNodeId: null,
      gridColumnApi: null
    };
  },
  components: {
    "ag-grid-vue": AgGridVue
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
    this.gridApi = this.gridOptions.api;
    this.gridColumnApi = this.gridOptions.columnApi;
    this.getTeachersData();
  },
  beforeMount() {
    this.columnDefs = [
      {
        headerName: "Id",
        field: "id",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Teacher Name",
        field: "teacher",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: " Subject",
        field: "subject",
        sortable: true,
        filter: true,
        editable: true
      },
      {
        headerName: "Designation",
        field: "designation",
        sortable: true,
        filter: true,
        editable: true
      }
    ];
    this.getTeachersData();
    this.gridOptions = {};
    this.getRowNodeId = data => {
      return data.id;
    };
  },
  methods: {
    getTeachersData() {
      axios.get("section/" + this.sectionId+'/teacher')
        .then(result => {
           this.rowData = result.data.data
        });
    },
    getRowData() {
      var rowData = [];
      this.gridApi.forEachNode(function(node) {
        rowData.push(node.data);
      });
    },
    clearData() {
      this.gridApi.setRowData([]);
    },
    addItems() {
      var res = this.gridApi.updateRowData({ add: [{}] });
    },
    addItemsAtIndex() {
      var res = this.gridApi.updateRowData({
        add: [{}],
        addIndex: 2
      });
    },
    save() {
      var data = getRowData();
    },
    updateItems() {
      var itemsToUpdate = [];
      this.gridApi.forEachNodeAfterFilterAndSort(function(rowNode, index) {
        if (index >= 5) {
          return;
        }
        var data = rowNode.data;
        data.price = Math.floor(Math.random() * 20000 + 20000);
        itemsToUpdate.push(data);
      });
      var res = this.gridApi.updateRowData({ update: itemsToUpdate });
    }
  },
  watch: {
    sectionId: function() {
      this.getTeachersData();
    },
    isActive: function() {
      if (this.isActive) {
        this.getTeachersData();
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
.btn-save {
  height: 30px;
  width: 80px;
  background-color: #2ca02c;
  color: #f5f5f5;
  border-radius: 4px;
}
</style>
