<script lang="ts" setup>
const {$userStore, $generalStore} = useNuxtApp()

let name = ref(null)
let email = ref(null)
let password = ref(null)
let confirmPassword = ref(null)
let errors = ref(null)

const register = async () => {
  errors.value = null
  try {
    await $userStore.getToken()
    await $userStore.register(name.value, email.value, password.value, confirmPassword.value)
    await $userStore.getUser()
    await $generalStore.getRandomUsers('suggested')
    await $generalStore.getRandomUsers('following')

    $generalStore.isLoginOpen = false
  } catch (error) {
    console.log(error)
    errors.value = error.response.data.errors
  }
}

</script>

<template>
  <div class="text-center text-[28px] mb-4 font-bold">Sign up</div>

  <div class="px-6 pb-1.5 text-[15px]">Full name</div>
  <div class="px-6 pb-2">
    <TextInput
        placeholder="Full name"
        v-model:input="name"
        inputType="name"
        :autofocus="true"
        :error="errors && errors.name ? errors.name[0] : ''"
    />
  </div>

  <div class="px-6 pb-1.5 text-[15px]">Email address</div>
  <div class="px-6 pb-2">
    <TextInput
        placeholder="Email address"
        v-model:input="email"
        inputType="email"
        :error="errors && errors.email ? errors.email[0] : ''"
    />
  </div>

  <div class="px-6 pb-1.5 text-[15px]">Password</div>
  <div class="px-6 pb-2">
    <TextInput
        placeholder="Password"
        v-model:input="password"
        inputType="password"
        :error="errors && errors.password ? errors.password[0] : ''"
    />
  </div>

  <div class="px-6 pb-1.5 text-[15px]">Confirm Password</div>
  <div class="px-6 pb-2">
    <TextInput
        placeholder="Confirm Password"
        v-model:input="confirmPassword"
        inputType="password"
        :error="errors && errors.confirmPassword ? errors.confirmPassword[0] : ''"
    />
  </div>

  <div class="px-6 text-[12px] text-gray-600">Forgot password?</div>

  <div class="px-6 pb-2 mt-6">
    <button
        :disabled="(!name || !email || !password || !confirmPassword)"
        :class="(!name || !email || !password || !confirmPassword) ? 'bg-gray-200' : 'bg-[#f02c56]'"
        @click="$event => register()"
        class="w-full text-[17px] font-semibold text-white py-3 rounded-sm"
    >
      Sign up
    </button>
  </div>

</template>

