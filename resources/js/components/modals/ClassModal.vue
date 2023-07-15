<template>
    <modal name="classModal" width="70%" height="70%">
        <div class="modal-content">
        <div class="backdrop" @click="$emit('closemodal')"></div>
        <div class="content">
            <div class="modal-header">
                <div class="header-text">Classes</div>
            </div>
            <div class="add-button btn-primary btn">
                <button @click="addSubject()">Add Classes</button>
            </div>
            </div>
        <ag-grid-vue
                class="ag-theme-blue"
                :columnDefs="columnDefs"
                :rowData="rowData"
                @grid-ready="onGridReady"
                rowSelection="multiple"
                style="overflow:scroll;"
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
    import classActionRender from "../tab-component/custom/classActionRender.js";
    export default {
        name: "ClassModal",
        components: {
            "ag-grid-vue": AgGridVue
        },
        data (){
            return{
                isActive: false,
                columnDefs: null,
                rowData: null,
                editType: null
            }
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
                    headerName: "Class Name",
                    field: "name",
                    sortable: true,
                    filter: true,
                    editable: true,
                    width: 200
                },
                {
                    headerName: "Action",
                    field : "action",
                    cellRenderer: "classActionRender",
                    sortable: true,
                    filter: true,
                    editable: true,
                    width: 200
                },

            ];
            this.frameworkComponents = {
                classActionRender : classActionRender
            },
            this.editType = "fullRow";},
        created(){
            this.updateRow();
        },
        mounted(){
            eventBus.$on('update-class' , this.updateRow)
        },
        methods :{
            updateRow(){
                axios.get("/class").then(resp => {
                    this.rowData = resp.data.classes;
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
                        .post(`/class/edit/${event.data.id}`, {
                            name: event.data.name
                        })
                        .then(data => {
                            this.$noty.success("Class name is updated");
                            eventBus.$emit('update-class');
                        }).catch(e => {
                                this.$noty.error("Error while updating class!");
                            });
                    } else {
                    axios
                        .post("/class/store", {
                            name: event.data.name
                        })
                        .then(res => {
                            this.$noty.success("Class name is added");
                            eventBus.$emit('update-class');
                            event.node.setData(res.data.subject);
                        }).catch(e => {
                                this.$noty.error("Error while adding class!");
                            });
                }
            }
        },
    }
</script>

<style scoped>

    .modal-header {
        font-size: 20px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
    }
    .action{
  font-size: 0.75rem;
  line-height: 1.5;
  border-radius: 0.2rem;
}
.modal-content{
     overflow-y:auto;
     height:calc(100% - 0px);
}
</style>