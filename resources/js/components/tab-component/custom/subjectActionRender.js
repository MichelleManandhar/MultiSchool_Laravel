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
            axios.get("subject/remove/" + this.params.data.id).then(result => {
                    this.$noty.success("Subject is removed");
                    eventBus.$emit('update-subject');
                }
            ).catch(e => {
                    this.$noty.error("Error while updating subject");
                }
            );
        },
        }
});