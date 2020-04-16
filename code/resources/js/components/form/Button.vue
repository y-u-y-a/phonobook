<template>
  <!-- clickで親側のtriggerを発火させ、親側のイベント実行 -->
  <button @click.stop="issueTrigger" type="submit" class="btn c-white bg-main">{{ button_name }}</button>
</template>


<script>
export default {
  props: ["button_name"],

  methods: {
    issueTrigger() {
      // $emitで親に対してイベントを発行
      this.$emit("trigger");
    }
  }
};
</script>
