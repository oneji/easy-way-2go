<template>
    <ul class="list-unstyled chat-list" data-simplebar style="max-height: 510px;">
        <contacts-list-item 
            v-for="idx in 10" :key="idx">
        </contacts-list-item>
    </ul>
</template>

<script>
import ContactsListItem from './ContactsListItem'

export default {
    components: {
        ContactsListItem
    }
}
</script>

<style>

</style>