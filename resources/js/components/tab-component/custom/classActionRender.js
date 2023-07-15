import Vue from "vue";
export default Vue.extend({
    template: `
        <span v-if="params.data.id">
        <button type="button" class="action" @click ="removeEvent" ><i class="far fa-trash-alt"></i> Remove</button>
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
        removeEvent(val){
                            axios.get("class/remove/" + this.params.data.id).then(result => {
                                    this.$noty.success("Class is removed");
                                    eventBus.$emit('update-class');
                                }
                            ).catch(e => {
                                    this.$noty.error("Error while updating class");
                                }
                            );
        },
        }
});