<template>
  <modal name="sponsorModal" width="60%" height="60%">
    <div class="modal-content">
      <div class="modal-header">
        <div class="header-text">Sponsor</div>
        <div class="add-button">
          <button @click="addSponsor()">Add Sponsor</button>
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
import sponsorActionRender from "../tab-component/custom/sponsorActionRender.js";
export default {
  name: "SponsorModal",
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
        headerName: "Name",
        field: "name",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      {
            headerName: "Address",
            field : "address",
            sortable: true,
            filter: true,
            editable: true,
            width: 200
        },
        {
        headerName: "Phone Number",
        field: "contact_no",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      {
        headerName: "Description",
        field: "description",
        sortable: true,
        filter: true,
        editable: true,
        width: 200
      },
      {
            headerName: "Action",
            field : "action",
            cellRenderer: "sponsorActionRender",
            sortable: true,
            filter: true,
            editable: true,
            width: 200
        },
    ];
      this.frameworkComponents = {
          sponsorActionRender : sponsorActionRender
      },
    this.editType = "fullRow";
    this.getSponsorData();
  },
   created(){
    this.getSponsorData();
    },
    mounted(){
      eventBus.$on('added-sponsor', this.getSponsorData)
    },
  methods: {
    getSponsorData() {
      axios.get("/sponsor/").then(resp => {
        this.rowData = resp.data.sponsors;
      });
    },
    addSponsor() {
      this.gridApi.updateRowData({ add: [{}] });
    },
    onGridReady(params) {
      this.gridApi = params.api;
      this.columnApi = params.columnApi;
    },

    rowValueChanged(event) {
      if (event.data.id != null) {
        axios.post(`/sponsor/edit/${event.data.id}`, {
            name: event.data.name,
            address:event.data.address,
            contact_no:event.data.contact_no,
            description:event.data.description 
          })
          .then(
            this.$noty.success('Sponsor has be edited.')
          ).catch(err => {
            this.$noty.error("Error in editing sponsor");
        });  
      } else {
        axios
          .post("/sponsor/store/", {
            name: event.data.name,
            address:event.data.address,
            contact_no:event.data.contact_no,
            description:event.data.description
          })
          .then(res => {
              eventBus.$emit('added-sponsor');
              this.$noty.success("Sponsor has been added.");
              event.node.setData(res.data.sponsor);
          }).catch(err => {
                this.$noty.error("Error in adding sponsor");

            });  
      }
    }
  }
};
</script>

<style scoped lang = "scss">
.ag-theme-blue {
  display: flex;
  width: 1000;
  height: 70vh;
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