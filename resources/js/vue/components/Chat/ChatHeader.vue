<template>
    <div class="py-2 border-bottom">
        <div class="media">
            <div class="align-self-center mr-3">
                <img :src="photo" class="avatar-xs rounded-circle" alt="">
            </div>
            <div class="media-body">
                <h5 class="font-size-15 m-0">{{ name }}</h5>
                <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle mr-1"></i> Active</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            defalt: '--'
        },
        photo: {
            type: String
        }
    }
}
</script>

<style>

</style>