<template>
    <DefaultLayout>
        <div class="pt-12 pb-4">
            <h1 class="text-3xl">
                {{ pageTitle }}
            </h1>
        </div>
        <MediaCollection :mediaCollection="mediaCollection.data"/>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import MediaCollection from "@/Pages/Media/Partials/MediaCollection.vue";

defineProps({
    pageTitle: {
      type: String,
      required: true
    },
    mediaCollection: {
        type: Object,
        required: true
    }
})
</script>
