<template>
  <div class="form-group">
    <label class="mb-05">{{ label }}</label>
    <select
      @change="issueTrigger"
      class="form-control">
      <option
        v-for="option in options"
        :key="option.name"
        :value="option.value"
        :selected="option.name == default_value"
      >{{ option.name }}</option>
    </select>
  </div>
</template>


<script>
export default {
  props: {
    // 中身は統一：[{name: "表示名", value: "値"}, {...}]
    options: {
      type: Array,
      required: true
    },

    default_value: {
      type: String,
      required: false
    },

    label: {
      type: String,
      required: false
    }
  },

  methods: {
    issueTrigger(e) {
      // 親側ではv-modelでOK(=@input+:value)
      this.$emit("input", e.target.value);
    }
  }
};
</script>
