<template>
    <div class=" background-modal d-flex justify-content-center">
        <div class="content-modal card w-50 h-25 my-4 py-2 " @click.stop>
            <div class="container my-auto">
                <h4>Are you sure you want to {{ message }}?</h4>
                <div class="d-flex flex-row justify-content-between mt-2">
                    <button class="form-control btn-danger me-2"
                            @click="cancelModal()">Cancel
                    </button>
                    <button class="form-control btn-success ms-2"
                            @click="confirmModal()">Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
export default {
    name: "ConfirmModal",
    props: {
        message: '',
        prop: '',
        exit: '',
        deletePhoto: '',
        edit: '',
    },
    data() {
        return {
            exitModal: ''
        }
    },

    methods: {
        confirmModal() {
            console.log(this.exitModal);
            this.exitModal = true;
            this.$emit("confirmModal", this.exitModal);
        },
        cancelModal() {
            console.log(this.exitModal);
            this.exitModal = false;
            this.$emit("cancelModal", this.exitModal);
        }
    },
    beforeMount() {
        this.exitModal = this.exit;
        console.log(this.prop);
    }
}
</script>

<style scoped>

</style>
