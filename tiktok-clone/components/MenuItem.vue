<script lang="ts" setup>
const props = defineProps(['iconString', 'colorString', 'sizeString'])
const { iconString, colorString, sizeString } = toRefs(props)

const icon = ref('')
if (iconString?.value === 'For You') icon.value = 'mdi:home'
if (iconString?.value === 'Following') icon.value = 'ci:group'
if (iconString?.value === 'LIVE') icon.value = 'ri:live-line'
</script>

<template>
  <div class="w-full flex items-center hover:bg-gray-100 p-2.5 rounded-md">
    <Icon :name="icon" :color="colorString" :size="sizeString" />
    <span
        :class="`text-[${colorString}]`"
        class="lg:block hidden pl-[9px] mt-0.5 font-semibold text-[17px]">
      {{ iconString}}
    </span>
  </div>
</template>
