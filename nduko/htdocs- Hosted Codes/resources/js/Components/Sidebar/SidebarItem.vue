<template>
    <li class="items-center">
        <Link
            :href="computedHref"
            class="text-xs uppercase py-3 font-bold block"
            :class="[
                  isActive
                    ? 'text-emerald-500 hover:text-emerald-600'
                    : 'text-blueGray-700 hover:text-blueGray-500',
                ]"
        >
            <i
                v-if="isActive"
                class="mr-2 text-sm opacity-75"
                :class="icon"
            ></i>
            <i v-else
                class="mr-2 text-sm text-blueGray-300"
                :class="icon"
            ></i>

            {{ name }}
        </Link>
    </li>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from 'vue';

const props = defineProps({
    name: {
        type: String,
    },
    routeName: {
        type: [String, Array],
        default: null,
    },
    href: {
        type: String,
        default: null,
    },
    icon: {
        type: String,
    },
});

const computedHref = computed(() => {
    if (props.href) return props.href;
    if (props.routeName) return route(props.routeName);
    return '#';
});

const isActive = computed(() => {
    if (props.routeName) return route().current(props.routeName);
    if (props.href) return route().current(props.href);
    return false;
});
</script>
