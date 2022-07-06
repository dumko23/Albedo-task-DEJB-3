<template>
    <div class="flex-row social-links">
        <ShareNetwork
            network="twitter"
            :url="this.url"
            :title="this.message"
            class="fa fa-twitter"
        ></ShareNetwork>
        <ShareNetwork
            network="facebook"
            :url="this.url"
            :title="this.message"
            class="fa fa-facebook"
        ></ShareNetwork>
    </div>
</template>

<script>
export default {
    name: "SocialLinks",
    data() {
        return {
            url: window.location.href,
            message: 'some text',
        }
    },
    beforeMount() {
        this.message = this.$attrs['social-message'];
    }

}
</script>

<style scoped>

</style>
