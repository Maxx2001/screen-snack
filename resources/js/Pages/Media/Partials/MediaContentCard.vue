<template>
    <Link
        :href="route('media.show',contentObject.mediaId)"
        class="flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow h-[30rem]"
    >
        <div class="flex flex-1 flex-col shadow p-2">
            <img
                v-if="contentObject.primaryImageUrl"
                class="mx-auto max-h-80 h-auto object-fit w-56 flex-shrink-0 rounded"
                v-lazy="contentObject.primaryImageUrl"
            />
            <h3 class="mt-6 text-sm font-medium text-gray-900">
                {{ contentObject.title }}
            </h3>
            <dl
                v-if="contentObject.captionText"
                class="mt-1 flex flex-grow flex-col justify-around"
            >
                <dd class="text-sm text-gray-500">
                    {{ contentObject.captionText }}
                </dd>
            </dl>
        </div>
    </Link>
</template>

<script setup>
import { Link} from "@inertiajs/vue3";

defineProps({
    contentObject: {
        type: Object,
        required: true
    }
})
</script>
