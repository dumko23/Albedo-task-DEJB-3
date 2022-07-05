<template>
    <div class="flex-row social-links">
        <a
           class="fa fa-twitter"
           :href="`https://twitter.com/intent/tweet?text=${this.message}&url=${this.url}`"
           @click="twOnclick"
           target="_blank"></a>
        <a
            class="fa fa-facebook"
            :href="`https://www.facebook.com/sharer/sharer.php?u=${this.url}`"
            @click="fbOnclick"
            target="_blank"></a>
    </div>
</template>

<script>
export default {
    name: "SocialLinks",
    data() {
        return {
            url: 'http://127.0.0.1:8000/',
            message: 'some text',
            socialLinks: {
                twitter: {
                    title: 'Twitter',
                    class: 'fa fa-twitter',
                    href: `https://twitter.com/intent/tweet?text=${this.message}&url=${this.url}`,
                    onclick: this.twOnclick,
                },
                fb: {
                    title: 'Facebook',
                    class: 'fa fa-facebook',
                    href: `https://www.facebook.com/sharer/sharer.php?u=${this.url}`,
                    onclick: this.fbOnclick,
                },
            }
        }
    },
    methods: {
        twOnclick() {
            window.open(this.socialLinks.twitter.href,
                'Twitter',
                'width=800,height=300,resizable=yes,toolbar=0,status=0');
            return false;
        },
        fbOnclick() {
            window.open(this.href,
                'Facebook',
                'width=640,height=436,toolbar=0,status=0');
            return false;
        }
    }
}
</script>

<style scoped>

</style>
