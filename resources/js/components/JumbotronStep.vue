<template>
    <div class="section jumbotron text-center">
        <h1 class="title">{{title}}</h1>
        <h2 class="subtitle">{{subtitle}}</h2>
        <p class="lead">{{content}}</p>
        <a :href="link" v-if="link">{{action}}</a>
        <button v-else @click="redirect" class="btn btn-primary btn-lg" role="button">
            {{action}}</button>
    </div>
</template>

<script>

export default {
    name: 'JumbotronStep',

    props: {
        title: {
            type: String,
            default: 'Contact List CSV Importer'
        },
        subtitle: {
            type: String,
            default: 'Laravel + Vue'
        },
        content: {
            type: String,
            default: 'Select a CSV file to import, then map the fields with the available options & import'
        },
        action: {
            type: String,
            default: 'Enter'
        },
        link: {
            type: String,
            default: null
        }
    },

    data: () => ({
        init: false,
    }),

    mounted () {
        this.init = true;
    },

    methods: {
        redirect (e) {
            this.$emit('changeState', e.target);
        }
    }
}
</script>

<style>

</style>