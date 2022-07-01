<template>
    <div>
        <map-content></map-content>

        <registration-form></registration-form>

        <div class="members-link">
            <router-link class="my-link " to="/members">All members ()</router-link>
        </div>
    </div>
</template>

<script>
import RegistrationForm from "../components/RegistrationForm";
export default {
    name: "Index",
    components: {RegistrationForm},
}
</script>

<style scoped>

</style>
