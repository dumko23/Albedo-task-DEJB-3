<template>
    <div>
        <router-link class="my-link" id="#top" to="/">Back to Register Form</router-link>

        <member-list></member-list>

        <a style="position: fixed; bottom: 0; left: 0;" class="my-link" href="#">To the top</a>
    </div>
</template>

<script>
import MemberList from "../components/form/MemberList";

export default {
    name: "Members",
    components: {MemberList},
}
</script>

<style scoped>

</style>
