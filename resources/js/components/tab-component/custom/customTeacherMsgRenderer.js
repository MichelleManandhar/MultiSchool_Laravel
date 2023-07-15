import Vue from "vue";

export default Vue.extend({
    template: `
        <span style="height:100%;width:100%">
            <input style="height:100%;width:100%" class="action" type="file" name="image" value=""   @change="fileUpload" accept="image/gif, image/jpeg, image/png">
        </span>
    `,
    data: function () {
        return {
            image: {}
        };
    },
    beforeMount() {
    },
    mounted() {
    },
    methods: {
        fileUpload(event){
            this.image = event.target.files[0];
            if (this.params.data.id != null) {
                axios
                    .post("/teacher/edit/"+this.params.data.id ,
                        this.data()
                    ).then(data => {
                    eventBus.$emit('update-teacher');
                    this.$noty.success("Teacher updated successfully");
                })
                .catch(e => {
                        this.$noty.error("Error while updating teacher");
                    });
            }else{
                eventBus.$emit('imageupload',{
                    image: this.image
                });
            }
        },
        data() {
            let formData = new FormData();

            for (let property in this.params.data) {
                if (Array.isArray(this.params.data[property])) {
                    for (let i = 0; i < this.params.data[property].length; i++) {
                        formData.append(`${property}[]`, this.params.data[property][i]);
                    }
                } else {
                    formData.append(property, this.params.data[property]);
                }
            }
            formData.append('image', this.image);
            return formData;
        }
    }
});