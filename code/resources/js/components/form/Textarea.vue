<template>
  <div class="form-group">
    <label class="mb-05">{{ label }}</label>
    <textarea
      @input="issueEvent"
      :value="value"
      :placeholder="placeholder"
      class="form-control" />
  </div>
</template>


<script>
export default {
  props: ["label", "placeholder", "value"],

  methods: {
    issueEvent(e) {
      this.$emit("input", e.target.value);
    }
  }
};
</script>
