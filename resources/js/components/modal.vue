<script setup>
defineProps({
    show: Boolean
})
</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="modal-mask">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header">default header</slot>
                </div>

                <div class="modal-body">
                    <slot name="body">default body</slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer">
                        default footer
                        <button
                            class="modal-default-button"
                            @click="$emit('close')"
                        >OK</button>
                    </slot>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped lang="scss">
@use "../../sass/modal.scss" as *;
</style>
