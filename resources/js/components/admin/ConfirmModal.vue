<template>
    <div class="background-modal d-flex justify-content-center">
        <div class="content-modal card w-50 h-25 my-4 py-2 " @click.stop>
            <div class="container my-auto">
                <h4 class="text-center">Are you sure you want to {{ message }}?</h4>
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
        deleteMember: ''
    },
    data() {
        return {
            exitModal: ''
        }
    },

    methods: {
        confirmModal() {
            this.exitModal = true;
            this.$emit("confirmModal", this.exitModal);
        },
        cancelModal() {
            this.exitModal = false;
            this.$emit("cancelModal", this.exitModal);
        }
    },
    beforeMount() {
        this.exitModal = this.exit;
    }
}
</script>

<style scoped>
.background-modal {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
}

.content-modal {
    overflow: auto;
}
</style>
