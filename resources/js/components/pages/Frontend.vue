<template>
  <template v-if="!has_dashboard">
    <section class="hero-3 bg-white">
      <div class="flex flex-wrap items-center">
        <div class="w-full lg:w-2/5 px-3">
          <div class="max-w-lg lg:max-w-md mx-auto lg:mx-0 mb-8 text-center lg:text-left">
            <h2 class="text-3xl lg:text-5xl mb-4 font-bold font-heading wow  header-solution">Exclusive
              Agency For <span class="text-blue-500">Technology </span>Provide Solution</h2>
            <div class="text-blueGray-400 leading-relaxed wow animate__animated animate__fadeIn">We are <strong
                class="text-blue-500">Monst</strong>, a Creative Design <div class="typewrite d-inline text-brand">
                <span>
                  <div style="display: inline-block;">Social Marketing</div><span
                    style="display: inline-block; transition: opacity 0.5s ease 0s; opacity: 1;">|</span>
                </span></div>
            </div>
            <p class="text-blueGray-400 leading-relaxed wow animate__animated animate__fadeIn mt-3 text-sm">Helping you
              maximize operations management with digitization</p>
          </div>
          <div class="text-center lg:text-left"><a
              class="tracking-wide hover-up-2 block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 text-xs text-white text-center font-semibold leading-none bg-blue-500 hover:bg-blue-700 rounded wow animate__animated animate__fadeIn"
              href="#key-features">Key Features</a><a
              class="block sm:inline-block hover-up-2 py-4 px-8 text-xs text-blueGray-500 hover:text-blueGray-600 text-center font-semibold leading-none bg-white border border-blueGray-200 hover:border-blueGray-300 rounded wow animate__animated animate__fadeIn"
              data-wow-delay=".3s" href="#how-we-work">How We Work?</a></div>
        </div>
        <div class="w-full lg:w-3/5 px-3 mb-12 lg:mb-0">
          <div class="lg:h-128 flex items-center justify-center"><img class="lg:max-w-lg"
              :src="$assets_url + '/images/work-tv.png'" alt="Monst"></div>
        </div>
      </div>
    </section>


    <section class="bg-slate-50 py-5" id="key-features">
      <div class="max-w-lg mx-auto mb-12 text-center">
        <h2 class="my-2 text-3xl md:text-4xl font-bold font-heading wow animate__animated animate__fadeIn"
          data-wow-delay=".1s">We Consultant to Get <span class="text-blue-500">Our Business</span> Plan</h2>
        <p class="text-blueGray-400 leading-loose wow animate__animated animate__fadeIn" data-wow-delay=".3s">Business
          solution company sit our any how site used the our company any site us it-solve theme is very professional</p>
      </div>
      <div class="flex flex-wrap  mb-6">
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".3s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                </path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">IT Consultancy</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".5s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">Web Development</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".7s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">App Development</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".9s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">Digital Marketing</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".3s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                </path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">Right Solutions</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".5s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">Responsive Site</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".7s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                </path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">Clean Design</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-1/4 px-3 mb-6">
          <div
            class="border border-gray-100 pt-8 px-6 pb-6 bg-white text-center rounded shadow hover:shadow-lg hover-up-2 transition duration-500 wow animate__animated animate__fadeIn"
            data-wow-delay=".9s">
            <div class="text-blue-500 mx-auto mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                </path>
              </svg></div>
            <h3 class="mb-2 font-bold font-heading">Process Research</h3>
            <p class="text-sm text-blueGray-400">We believe brand interaction is key to communication. Real innovations
              and positive customer experience are the heart of success.</p>
          </div>
        </div>
      </div>

    </section>

    <section class="py-12 bg-white">
      <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 px-3 order-0 md:order-1 mb-12 md:mb-0 wow animate__animated animate__fadeIn"
          data-wow-delay=".5s"><img class="sm:max-w-sm lg:max-w-full mx-auto" :src="$assets_url + 'images/podcast.svg'"
            alt="Monst"></div>
        <div class="w-full md:w-1/2 px-3 order-1 md:order-0">
          <div class="max-w-md">
            <h3 class="mb-4 text-3xl md:text-3xl font-bold font-heading wow animate__animated animate__fadeIn"
              data-wow-delay=".3s">How we work?</h3>
            <p class="mb-6 leading-loose text-blueGray-400 wow animate__animated animate__fadeIn" data-wow-delay=".5s">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis.</p>
            <ul>
              <li class="py-4 wow animate__animated animate__fadeIn" data-wow-delay=".7s"><span
                  class="inline-block py-2 px-4 mr-4 text-xs font-semibold bg-blue-500 text-white rounded">1</span><span>Expand
                  Your Reach</span></li>
              <li class="py-4 wow animate__animated animate__fadeIn" data-wow-delay=".9s"><span
                  class="inline-block py-2 px-4 mr-4 text-xs font-semibold bg-blue-500 text-white rounded">2</span><span>Annualized
                  Growth</span></li>
              <li class="pt-4 wow animate__animated animate__fadeIn" data-wow-delay=".11s"><span
                  class="inline-block py-2 px-4 mr-4 text-xs font-semibold bg-blue-500 text-white rounded">3</span><span>Book
                  Your Providers</span></li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </template>

  <template v-else>
    <component :is="dashboard"></component>
  </template>

</template>

<script>

export default {
  data() {
    return {
      has_dashboard: false,
      dashboard: null,
    };
  },

  beforeMount() {
    if (window.is_backend) {
      this.$router.push("/manage/dashboard");
    }

    var path_url = window.base_url + '/fetch_vue/templates/user/pages/Dashboard.vue';

    fetch(path_url)
      .then(response => {
        console.log(response);
        if (response.ok) {
          this.has_dashboard = true;
          this.dashboard = window.$filters.fetchComponent('templates/user/pages/Dashboard.vue');
        }
      })
      .catch(error => {

        this.has_dashboard = false;

        console.error('There was an error!', error);
      });
  }
}

</script>

<style>
.header-solution {
  line-height: 4rem !important;
}
</style>
