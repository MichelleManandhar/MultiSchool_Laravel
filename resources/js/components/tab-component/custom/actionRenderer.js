import Vue from "vue";
export default Vue.extend({
    template: `
        <span>
            <a class="action" @click ="leaveEvent"><i class='fa fa-flag'></i>Leave</a>
            <a class="action" @click ="promoteEvent"><i class='fa fa-graduation-cap'></i>Promote</button></a>
            <a class="action" @click ="demoteEvent"><i class='fa fa-arrow-down'></i>Demote</button></a>
        </span>
    `,
    data: function () {
        return {
        };
    },
    beforeMount() {
    },
    mounted() {
    },
    methods: {
        leaveEvent(){
            if(this.params.data.id !=null){
                axios.get("/leave/student/" + this.params.data.id).then(result => {
                    this.$noty.success(result.data.message)
                    eventBus.$emit('update-student');
                    }
                ).catch(e => {
                        this.$noty.error("Error while updating student");
                    }
                );

                axios.post("/studentHistory/"+ this.params.data.id,{event:'Leave'})
                .then(res=>{
                    this.$noty.success("Student left");
                })
                .catch(e=>{
                    this.$noty.error("Error while leaving student");
                })
            }
        },
        demoteEvent(){
            if(this.params.data.id !=null){
                axios.get("/demote/student/" + this.params.data.id).then(result => {
                    this.$noty.success(result.data.message)
                    eventBus.$emit('update-student');
                    }
                ).catch(e => {
                        this.$noty.error("Error while updating student");
                    }
                );

                axios.post("/studentHistory/"+ this.params.data.id,{event:'Demote'})
                .then(res=>{
                    this.$noty.success("Student demoted successfully");
                })
                .catch(e=>{
                    this.$noty.error("Error while demoting student");
                })
            }
        },
        promoteEvent(){
            if(this.params.data.id !=null){
                axios.get("/promote/student/" + this.params.data.id).then(result => {
                    this.$noty.success(result.data.message)
                    eventBus.$emit('update-student');
                    }
                ).catch(e => {
                        this.$noty.error("Error while updating student");
                    }
                );

                axios.post("/studentHistory/"+ this.params.data.id,{event:'Promote'})
                .then(res=>{
                    this.$noty.success("Student promoted successfully");
                })
                .catch(e=>{
                    this.$noty.error("Error while promoting student");
                })
            }
        }}
});
