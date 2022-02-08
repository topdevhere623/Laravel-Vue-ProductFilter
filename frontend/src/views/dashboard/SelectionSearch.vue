<template>
  <div style="display: flex; justify-content: center; align-items: center">
    <span style="font-size:14px; margin-right: 10px; margin-bottom:5px">{{ title }}: </span>
    <v-autocomplete
      v-model="select"
      :items="items"
      :search-input.sync="search"
      dense
      outlined
      hide-no-data
      label="Выберите значение"
    ></v-autocomplete>
    <a @click="removeFilter(type)" style="margin-left: 5px; margin-bottom:5px">
      <v-icon>mdi-cancel</v-icon>
    </a>
  </div>
</template>

<script>
  export default {
    props: {
      type: String,
      title: String,
      states: Array,
      changeFilter: Function,
      clearFilter: Function
    },
    data () {
      return {
        loading: false,
        items: [],
        search: null,
        select: null,
      }
    },
    mounted() {
      console.log("Brands", this.states)
    },
    watch: {
      search (val) {
        val !== this.select && this.querySelections(val)
      },
      select (val) {
        console.log('select', this.type, val);
        this.changeFilter(this.type, val !== null ? val : '');
      }
    },
    methods: {
      querySelections (v) {
        this.loading = true
        // Simulated ajax query
        setTimeout(() => {
          this.items = this.states.filter(e => {
            return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
          })
          this.loading = false
        }, 500)
      },
      removeFilter(type) {
        this.select = '';
        this.clearFilter(type);
      }
    },
  }
</script>

<style scoped>
  .v-autocomplete >>> label {
    font-size: 14px !important;
    top: 5px !important;
  }
  .v-autocomplete >>> fieldset {
    margin-bottom: 20px !important;
    height: 33px !important
  }
  .v-autocomplete >>> i {
    margin-bottom: 20px !important;
  }
  .v-autocomplete >>> div {
    height: 33px;
  }
</style>