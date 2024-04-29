<template>
    <div>
        <Breadcrumbs main="Admin Dashboard" title="default" />

        <div class="container-fluid">
            <div class="row widget-grid">
                <WelcomeCard />
            </div>
        </div>

    </div>
</template>

<script>
import WelcomeCard from "./WelcomeCard.vue";

export default {
    components: {
        WelcomeCard,
    },
};
</script>
