<template>
    <div class="section-modal">
        <div class="backdrop" @click="$emit('closemodal')"></div>
        <div class="content">
            <div class="modal-header">
                <div class="header-text">Class <p v-text="classname"></p>
                </div>
                <div class="add-button">
                    <button @click="addRow">Add section</button>
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
                    :enterMovesDownAfterEdit="true"
                    :enterMovesDown="true"
                    @rowValueChanged="storeOrUpdate"
                    @keypress.shift.delete="deleteSelected"
            >
            </ag-grid-vue>
        </div>
    </div>
</template>

<script>
    import {AgGridVue} from "ag-grid-vue";
    export default {
        name: 'SectionModal',
        props: {
            'classid': {
                required: true
            },
            'classname': {
                required: true
            }
        },
        components: {
            'ag-grid-vue': AgGridVue
        },
        data() {
            return {
                columnDefs: null,
                rowData: null,
                editType: null
            }
        },
        mounted() {
            this.columnDefs = [
                {
                    headerName: "S.N",
                    cellRenderer : function (params) {
                        return parseInt(params.node.id) + 1;
                    },
                    field: "id",
                    sortable: true,
                    filter: true,
                    width: 200
                },
                {
                    headerName: "Section Name",
                    field: "name",
                    sortable: true,
                    filter: true,
                    editable: true,
                    width: 200
                }
            ];
            this.editType = "fullRow";
            this.getSectionsData();
            
        },
        methods: {
            getSectionsData() {
                axios.get(`/class/${this.classid}/section/`).then(resp => {
                    this.rowData = resp.data;
                }).catch(err => {
                    this.$noty.error('Error while downloading the section detail')
                });
            },
            storeOrUpdate(event) {
                if (!event.data.id) {
                    axios.post(`class/${this.classid}/section`,event.data).then(response => {
                        this.$noty.success('Successfully added section!');
                        event.node.setData(response.data.section_data);
                    }).catch(err => {
                        this.$noty.error('Error while adding section!')
                    });
                    eventBus.$emit('section-updated');
                }
                else {
                    axios.put(`class/${this.classid}/section/${event.data.id}`,event.data).then(response => {
                        this.$noty.success('Successfully edited section!');
                    }).catch(err => {
                        this.$noty.error('Error while editing section!')
                    });
                    eventBus.$emit('section-updated');
                }
            },
            addRow () {
                this.gridApi.updateRowData({add: [{}]});
            },
            onGridReady(params) {
                this.gridApi = params.api;
                this.columnApi = params.columnApi;
            },
            deleteSelected(){
                axios.delete(`class/${this.classid}/section`, {
                        sections: this.gridApi.getSelectedRows()
                    })
                    .then(res => {
                        this.getSubjectsData();
                    });
            }
        }
    }
</script>

<style scoped>
    .section-modal {
        position: fixed;
        height: 100%;
        width: 100%;
        left: 0;
        top: 0;
        background-color: rgba(0, 0, 0, 0.52);
        z-index: 9;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .ag-theme-blue {
        display: flex;
        height: 30%;
        width: 85%;
        margin-left: 30px;
        margin-top: 30px;
        margin-right: 30px;
        z-index: 7;
    }

    .backdrop {
        height: 100%;
        width: 100%;
        position: absolute;
        left: 0;
        top: 0;
    }

    .content {
        color: black;
        width: 50%;
        height: 60%;
        background: white;
        z-index:10;
    }

    .modal-header {
        font-size: 20px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        z-index: 3;
    }

    button {
        background-color: rgb(0, 136, 199);
        color: white;
        padding: 10px;
        box-sizing: border-box;
    }
</style>