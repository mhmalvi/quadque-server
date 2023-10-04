<template>
  <div>
    <!-- <fade-transition> -->
    <lottie-vue-player
      v-if="loader"
      :src="`./9582-liquid-4-dot-loader.json`"
      style="
        top: 40%;
        position: sticky;
        background: transparent;
        z-index: 100;
        margin-left: -5%;
      "
    >
    </lottie-vue-player>
    <div class="row d-flex justify-content-center">
      <div
        v-if="this.is_editing == true"
        @click="disable_button()"
        class="mt-3"
      >
        <button class="btn btn-primary">Add Products</button>
      </div>
      <div class="col-sm-12 mt-4">
        <div class="row" style="justify-content: space-around">
          <!-- {{ this.product_id }} -->
          <h1 v-if="this.product_id == 0 && edit == 0">Step 1</h1>
          <div class="mx-auto d-flex" v-if="this.product_id == 0">
            <div class="card">
              <div
                class="card-header text-center"
                style="
                  height: 47px;
                  background-image: linear-gradient(
                    to right,
                    rgb(242, 112, 156),
                    rgb(255, 148, 114)
                  );
                "
              >
                <h4
                  v-if="plan_id === 0 || edit === 1"
                  :class="
                    this.product_id == 0 || edit === 1
                      ? 'card-title text-white text-center'
                      : ''
                  "
                  style="margin: auto"
                >
                  {{ edit === 1 ? "Update Product" : "Create Product" }}
                </h4>
              </div>
              <div class="card-body" v-if="plan_id === 0 || edit === 1">
                <form @submit.prevent="save()" method="post">
                  <div class="form-group">
                    <!-- {{ product_main_id }} -->
                    <label for="title">Product Name</label><br />
                    <input
                      type="text"
                      class="form-control"
                      v-model="product_name"
                      :required="required"
                    />
                    <!-- <div class="text-danger" v-if="this.titleError">
                      {{ this.titleError }}
                    </div> -->
                  </div>
                  <div class="form-group">
                    <label for="title">Product Logo</label><br />

                    <input
                      type="file"
                      class="form-control"
                      @change="product_logo"
                      required
                    />
                    <img
                      v-if="is_editing"
                      style="width: 146px; height: 150px"
                      :src="$base + fetch_prod_logo"
                      alt="No image"
                    />
                    <!-- <div class="text-danger" v-if="this.imageError">
                      {{ this.imageError }}
                    </div> -->
                  </div>
                  <div class="form-group">
                    <label for="title">Title</label><br />
                    <input
                      type="text"
                      class="form-control"
                      v-model="title"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="title">Description</label><br />
                    <textarea
                      class="form-control"
                      v-model="description"
                      required
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label for="title">Cover Image</label><br />
                    <input
                      type="file"
                      class="form-control"
                      @change="cover_image"
                      required
                    />
                    <img
                      v-if="is_editing"
                      style="width: 146px; height: 150px"
                      :src="$base + fetch_cover_img"
                      alt="No image"
                    />
                  </div>
                  <div class="form-group">
                    <label for="title">Features Description</label><br />
                    <textarea
                      class="form-control"
                      v-model="features_first_description"
                      required
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label for="title">Features Image</label><br />
                    <input
                      type="file"
                      class="form-control"
                      @change="feature_photo"
                      required
                    />
                    <img
                      v-if="is_editing"
                      style="width: 146px; height: 150px"
                      :src="$base + fetch_feature_image"
                      alt="No image"
                    />
                  </div>
                  <div class="form-group">
                    <label for="title">Features Second Description</label><br />
                    <textarea
                      class="form-control"
                      v-model="features_second_description"
                      required
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label for="title">Total Users</label><br />
                    <input
                      type="text"
                      class="form-control"
                      v-model="total_users"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="title">Key Points Header</label><br />
                    <!-- <input
                      type="text"
                      class="form-control"
                      v-model="key_points_header"
                    /> -->
                    <textarea
                      class="form-control"
                      v-model="key_points_header"
                      id=""
                      required
                    >
                    </textarea>
                  </div>

                  <!-- {{ id }} -->
                  <div v-if="edit === 0">
                    <button
                      type="button"
                      @click="save(), greet()"
                      class="btn btn-block btn-save text-white"
                    >
                      Save
                      <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                    </button>
                  </div>
                  <div v-else>
                    <button
                      type="button"
                      @click="update(product_main_id), greet()"
                      class="btn btn-block btn-save text-white"
                    >
                      Update
                      <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                    </button>
                  </div>
                  <div v-if="is_editing == true"></div>
                </form>
              </div>
            </div>
          </div>
          <div class="mx-auto d-flex">
            <section
              class="w-full flex justify-center items-center mx-auto my-10"
            >
              <h1
                style="margin-left: -189px"
                v-if="
                  product_id !== 0 &&
                  skip === false &&
                  key_point_id === 0 &&
                  edit === 0
                "
              >
                Step 2
              </h1>
              <h4
                v-if="
                  (product_id !== 0 && skip === false && key_point_id === 0) ||
                  edit === 1
                "
              >
                Plans
              </h4>
              <div
                v-if="
                  product_id !== 0 &&
                  skip === false &&
                  key_point_id === 0 &&
                  edit === 0
                "
              >
                <div
                  v-for="(input, index) in solved_array"
                  :key="`phoneInput-${index}`"
                  class="input wrapper flex items-center"
                >
                  <form @submit.prevent="plan_save(index)">
                    <div class="form-group">
                      <!-- <label class="text-gray-600 font-semibold text-lg"
                    >Phone Number</label
                  > -->
                      <!-- {{ input.form_name }} -->

                      <input
                        type="text"
                        v-model="input.plan"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter plan"
                        required
                      />
                      <input
                        type="string"
                        v-model="input.price"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter price"
                        required
                      />

                      <!--          Remove Svg Icon-->
                      <svg
                        v-show="solved_array.length > 1"
                        @click="removeField(index, solved_array)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="24"
                        height="24"
                        class="ml-2 cursor-pointer"
                      >
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                          fill="#EC4899"
                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                        />
                      </svg>
                    </div>
                    <div v-if="edit === 0" class="form-group">
                      <button
                        type="submit"
                        class="btn btn-block btn-save text-white"
                        :disabled="input.disabled"
                        @click="plan_save(input, solved_array, index, input)"
                      >
                        <!-- addField(input, solved_array) -->
                        <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                        Save
                      </button>
                    </div>
                    <p v-if="edit === 0">Or</p>
                    <div v-if="edit === 0" class="form-group">
                      <button
                        type="button"
                        style="width: 100%"
                        class="btn btn-dark text-white"
                        :disabled="input.disabled"
                        @click="skip_plan()"
                      >
                        <!-- addField(input, solved_array) -->
                        <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                        Skip
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div v-if="edit === 1">
                <div
                  v-for="(input, index) in solved_array[0].plan_data"
                  :key="`phoneInput-${index}`"
                  class="input wrapper flex items-center"
                >
                  <form>
                    <div class="form-group">
                      <button
                        v-if="input.id"
                        type="button"
                        style="
                          margin-left: 40%;
                          position: absolute;
                          border: none;
                        "
                        @click="destroy_prototype(input.id, 'plan')"
                      >
                        <img
                          style=""
                          :src="
                            $base + 'assets/delete_button_gif/icons8-delete.gif'
                          "
                          alt=""
                        />
                      </button>
                      <input
                        type="text"
                        v-model="input.plan"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter plan"
                        required
                      />
                      <input
                        type="string"
                        v-model="input.price"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter price"
                        required
                      />

                      <!--          Remove Svg Icon-->
                      <svg
                        v-show="solved_array.length > 1"
                        @click="removeField(index, solved_array)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="24"
                        height="24"
                        class="ml-2 cursor-pointer"
                      >
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                          fill="#EC4899"
                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                        />
                      </svg>
                    </div>
                    <!-- <div > -->
                    <button
                      v-if="!input.id"
                      @click="removeEditField(index, solved_array[0].plan_data)"
                      type="button"
                    >
                      <img
                        style="
                          margin-left: 40%;
                          position: absolute;
                          border: none;
                        "
                        :src="
                          $base + 'assets/icons/minus.gif'
                        "
                        alt=""
                      />
                    </button>
                    <!-- </div> -->
                    <div v-if="input.id" class="form-group">
                      <button
                        @click="update_plan(input.id, index)"
                        type="button"
                        class="btn btn-block btn-save text-white"
                      >
                        <!-- addField(input, solved_array) -->
                        <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                        Update
                      </button>
                    </div>
                    <div v-if="!input.id" class="form-group">
                      <button
                        type="button"
                        @click="add_data('plan', index)"
                        class="btn btn-block btn-save text-white"
                      >
                        <!-- addField(input, solved_array) -->
                        <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                        Update
                      </button>
                    </div>
                  </form>
                  <!-- <button></button> -->
                </div>
                <div>
                  <button
                    type="button"
                    class="btn"
                    @click="addEditField(input, solved_array[0].plan_data)"
                  >
                    <img :src="$base + 'assets/icons/plus.gif'" alt="" />
                  </button>
                </div>
              </div>
              <h1
                style="margin-left: -189px"
                v-if="feature_id === 0 && plan_id !== 0 && edit === 0"
              >
                Step 3
              </h1>
              <h4
                v-if="
                  (feature_id === 0 && plan_id !== 0) ||
                  skip === true ||
                  edit === 1
                "
                style="margin-top: 60px"
              >
                Key Points
              </h4>
              <div v-if="(feature_id === 0 && plan_id !== 0) || skip === true">
                <div
                  v-for="(input_two, index) in key_points_array"
                  :key="`keyPointsInput-${index}`"
                >
                  <form @submit.prevent="key_points_save(index)">
                    <div class="form-group">
                      <!-- <label class="text-gray-600 font-semibold text-lg"
                    >Phone Number</label
                  > -->
                      <input
                        type="text"
                        v-model="input_two.key_points_title"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter title"
                        required
                      />

                      <input
                        type="text"
                        v-model="input_two.key_points_text"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter key points text"
                        required
                      />
                      <input
                        type="file"
                        class="form-control"
                        required
                        @change="key_points_image_func"
                      />

                      <!--          Remove Svg Icon-->
                      <svg
                        v-show="key_points_array.length > 1"
                        @click="removeKeypointsField(index, key_points_array)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="24"
                        height="24"
                        class="ml-2 cursor-pointer"
                      >
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                          fill="#EC4899"
                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                        />
                      </svg>
                    </div>
                    <div v-if="edit === 0" class="form-group">
                      <button
                        type="submit"
                        class="btn btn-block btn-save text-white"
                        :disabled="input_two.key_btn_disabled"
                        @click="
                          key_points_save(input_two, key_points_array, index)
                        "
                      >
                        <!-- addField(input, solved_array) -->
                        <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                        Save
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div v-if="edit === 1">
                <div
                  v-for="(input_two, index) in key_points_array[0].key_points"
                  :key="`keyPointsInput-${index}`"
                >
                  <button
                    v-if="input_two.id"
                    type="button"
                    style="margin-left: 40%; position: absolute; border: none"
                    @click="destroy_prototype(input_two.id, 'key_point')"
                  >
                    <img
                      style=""
                      :src="
                        $base + 'assets/delete_button_gif/icons8-delete.gif'
                      "
                      alt=""
                    />
                  </button>
                  <form
                    @submit.prevent="key_points_update(input_two.id, index)"
                  >
                    <div class="form-group">
                      <!-- <label class="text-gray-600 font-semibold text-lg"
                    >Phone Number</label
                  > -->
                      <input
                        type="text"
                        v-model="input_two.key_points_title"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter title"
                        required
                      />

                      <input
                        type="text"
                        v-model="input_two.key_points_text"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter key points text"
                        required
                      />
                      <!-- {{ input_two.key_points_image }} -->

                      <input
                        type="file"
                        class="form-control"
                        @change="key_points_image_update_func"
                      /><br />
                      <div>
                        <img
                          v-if="input_two.id"
                          class="form-control"
                          style="width: 146px; height: 150px"
                          :src="$base + input_two.key_points_image"
                          alt="No image"
                        />
                      </div>

                      <!--          Remove Svg Icon-->
                      <svg
                        v-show="key_points_array.length > 1"
                        @click="removeKeypointsField(index, key_points_array)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="24"
                        height="24"
                        class="ml-2 cursor-pointer"
                      >
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                          fill="#EC4899"
                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                        />
                      </svg>
                    </div>
                    <div v-if="!input_two.id">
                      <button
                        @click="
                          removeEditField(index, key_points_array[0].key_points)
                        "
                        type="button"
                      >
                        <img
                          style="
                            margin-left: 40%;
                            position: absolute;
                            border: none;
                          "
                          :src="
                            $base + 'assets/icons/minus.gif'
                          "
                          alt=""
                        />
                      </button>
                    </div>
                    <div v-if="input_two.id" class="form-group">
                      <button
                        type="submit"
                        class="btn btn-block btn-save text-white"
                      >
                        Update
                      </button>
                    </div>
                    <div v-if="!input_two.id" class="form-group">
                      <button
                        type="button"
                        @click="add_data('key', index)"
                        class="btn btn-block btn-save text-white"
                      >
                        Update
                      </button>
                    </div>
                  </form>
                </div>
                <div>
                  <button
                    type="button"
                    class="btn"
                    @click="
                      addEditField(input_two, key_points_array[0].key_points)
                    "
                  >
                    <img :src="$base + 'assets/icons/plus.gif'" alt="" />
                  </button>
                </div>
              </div>
              <h1
                style="margin-left: -189px"
                v-if="key_point_id !== 0 && edit === 0"
              >
                Step 4
              </h1>
              <h4
                v-if="key_point_id !== 0 || edit === 1"
                style="margin-top: 60px"
              >
                Features and Capabilities
              </h4>
              <div v-if="key_point_id !== 0">
                <div
                  v-for="(input_five, index) in features_array"
                  :key="`featuresInput-${index}`"
                >
                  <form @submit.prevent="features_save(index)">
                    <div class="form-group">
                      <!-- <label class="text-gray-600 font-semibold text-lg"
                    >Phone Number</label
                  > -->
                      <input
                        type="text"
                        v-model="input_five.title"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter title"
                        required
                      />

                      <textarea
                        class="form-control"
                        v-model="input_five.description"
                        required
                      ></textarea>

                      <!--          Remove Svg Icon-->
                      <svg
                        v-show="features_array.length > 1"
                        @click="removeFeaturesField(index, features_array)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="24"
                        height="24"
                        class="ml-2 cursor-pointer"
                      >
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                          fill="#EC4899"
                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                        />
                      </svg>
                    </div>
                    <div class="form-group">
                      <button
                        type="submit"
                        class="btn btn-block btn-save text-white"
                        :disabled="input_five.feature_btn_disabled"
                        @click="
                          features_save(input_five, features_array, index)
                        "
                      >
                        <!-- addField(input, solved_array) -->
                        <!-- {{ this.is_editing ? "Update" : "Save" }} -->
                        Save
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <div v-if="edit === 1">
                <div
                  v-for="(input_five, index) in features_array[0].features_data"
                  :key="`featuresInput-${index}`"
                >
                  <button
                    v-if="input_five.id"
                    type="button"
                    style="margin-left: 40%; position: absolute; border: none"
                    @click="destroy_prototype(input_five.id, 'feature')"
                  >
                    <img
                      style=""
                      :src="
                        $base + 'assets/delete_button_gif/icons8-delete.gif'
                      "
                      alt=""
                    />
                  </button>
                  <form>
                    <div class="form-group">
                      <!-- <label class="text-gray-600 font-semibold text-lg"
                    >Phone Number</label
                  > -->
                      <input
                        type="text"
                        v-model="input_five.title"
                        class="h-10 rounded-lg outline-none p-2 form-control"
                        placeholder=" Enter title"
                        required
                      />
                      <textarea
                        class="form-control"
                        v-model="input_five.description"
                        required
                      ></textarea>

                      <!--          Remove Svg Icon-->
                      <svg
                        v-show="features_array.length > 1"
                        @click="removeFeaturesField(index, features_array)"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="24"
                        height="24"
                        class="ml-2 cursor-pointer"
                      >
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                          fill="#EC4899"
                          d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9.414l2.828-2.829 1.415 1.415L13.414 12l2.829 2.828-1.415 1.415L12 13.414l-2.828 2.829-1.415-1.415L10.586 12 7.757 9.172l1.415-1.415L12 10.586z"
                        />
                      </svg>
                    </div>
                    <div v-if="!input_five.id">
                      <button
                        @click="
                          removeEditField(
                            index,
                            features_array[0].features_data
                          )
                        "
                        type="button"
                      >
                        <img
                          style="
                            margin-left: 40%;
                            position: absolute;
                            border: none;
                          "
                          :src="
                            $base + 'assets/icons/minus.gif'
                          "
                          alt=""
                        />
                      </button>
                    </div>
                    <div v-if="input_five.id" class="form-group">
                      <button
                        type="button"
                        @click="features_update(input_five.id, index)"
                        class="btn btn-block btn-save text-white"
                      >
                        Update
                      </button>
                    </div>
                    <div v-if="!input_five.id" class="form-group">
                      <button
                        type="button"
                        @click="add_data('feature', index)"
                        class="btn btn-block btn-save text-white"
                      >
                        Update
                      </button>
                    </div>
                  </form>
                </div>
                <div>
                  <button
                    type="button"
                    class="btn"
                    @click="
                      addEditField(input_five, features_array[0].features_data)
                    "
                  >
                    <img :src="$base + 'assets/icons/plus.gif'" alt="" />
                  </button>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-5">
      <form>
        <div class="form-group">
          <label for="text"
            >Benefits
            <span style="font-weight: 800">
              (Please create content in google docs and then copy and paste in
              the editor)</span
            ></label
          >
          <select v-model="using_purpose" id="" class="summernote"></select>
        </div>
        <div v-if="edit === 0" class="form-group">
          <button
            type="submit"
            v-if="this.feature_id != 0 || edit === 1"
            class="btn btn-block btn-save text-white"
            @click="purpose()"
          >
            <!-- addField(input, solved_array) -->
            <!-- {{ this.is_editing ? "Update" : "Save" }} -->
            Save
          </button>
        </div>
        <div v-else class="form-group">
          <button
            type="button"
            v-if="edit === 1"
            class="btn btn-block btn-save text-white"
            @click="benefits_update(benefits_id)"
          >
            <!-- addField(input, solved_array) -->
            <!-- {{ this.is_editing ? "Update" : "Save" }} -->
            Update
          </button>
        </div>
      </form>
    </div>
    <div class="row mt-5 d-flex justify-content-center">
      <div class="col-md-12">
        <h4>Products List</h4>
        <table class="table table-striped text-center">
          <thead>
            <tr>
              <th>No.</th>
              <th>product title</th>
              <th>product caption</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="lists.length > 0">
            <tr v-for="(list, index) in lists" :key="index">
              <td style="vertical-align: middle; font-weight: 500">
                {{ index + 1 }}.
              </td>

              <td style="vertical-align: middle; font-weight: 500">
                {{ list.title }}
              </td>

              <td style="vertical-align: middle">
                {{ list.product_name }}
              </td>
              <td style="vertical-align: middle; width: 15%; color: white">
                <button
                  type="button"
                  class="btn btn-primary text-white"
                  @click="editList(list.id), greet()"
                >
                  Edit</button
                ><button
                  type="button"
                  class="btn btn-danger ml-1"
                  @click="destroyList(list.id)"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>

          <tbody v-else>
            <tr>
              <td colspan="8">
                <h3 class="text-center">Product is empty...!</h3>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- <pagination :data="laravelData" @pagination-change-page="getResults"></pagination> -->
      </div>
      <!-- <JwPagination :items="lists" @changePage="onChangePage"></JwPagination> -->
      <pagination-component
        v-if="last_page > 1"
        :pagination="pagination"
        :offset="5"
        @paginate="fetchAll"
      />
    </div>
    <!-- </fade-transition> -->
  </div>
</template>
<script>
import axios from "axios";
import { exit } from "process";
// import pagination from "laravel-vue-pagination";
import JwPagination from "jw-vue-pagination";
// import { arrayBuffer } from 'stream/consumers';

export default {
  components: {
    // pagination,
    // JwPagination,
  },
  data() {
    return {
      pageOfItems: [],
      pagination: {
        current_page: 1,
      },
      solved_array: [
        {
          plan: "",
          form_name: "",
          price: "",
          plan_data: [
            {
              plan: "",
              form_name: "",
              price: "",
            },
          ],
          disabled: false,
        },
      ],

      key_points_array: [
        {
          key_points_title: "",
          key_points_text: "",
          key_points: [
            {
              key_points_title: "",
              key_points_text: "",
            },
          ],
          key_btn_disabled: false,
        },
      ],

      key_points_image_update: "",

      features_array: [
        {
          title: "",
          description: "",
          feature_btn_disabled: false,
          features_data: [
            {
              title: "",
              description: "",
            },
          ],
        },
      ],

      tech_array: [
        {
          technologies: "",
          tech_btn_disabled: false,
        },
      ],
      tech_id: "",
      product_name: "",
      product_id: "",
      product_main_id: "",
      description: "",
      problem_solution_title: "",
      features_first_description: "",
      features_second_description: "",
      feature_image: "",
      fetch_feature_image: "",
      total_users: "",
      feature_id: "",

      key_points_header: "",
      key_point_id: "",
      key_points_description: "",
      key_points_image: "",

      prod_logo: "",
      fetch_prod_logo: "",
      cover_img: "",
      fetch_cover_img: "",
      skip: false,
      // solved_problem_title: "",
      solved_problem: [],
      plan_id: "",
      is_editing: false,
      editable_data: [],
      loader: false,
      lists: [],
      album_id: "",
      gallery_images: [],
      title: "",
      image: "",
      album_caption: "",
      image_replace: [],
      solved_problem_image: "",
      using_purpose: "",
      benefits_id: "",
      purpose_id: "",
      per_page: 5,
      last_page: "",

      edit: 0,
      is_editing: false,
    };
  },
  methods: {
    onChangePage(pageOfItems) {
      // update page of items
      this.pageOfItems = pageOfItems;
    },

    addEditField(value, array) {
      array.push({ value: "" });
    },

    removeEditField(index, array) {
      array.splice(index, 1);
    },

    add_data(flag, index) {
      // console.log(this.solved_array[0].plan_data[index]);
      let product_id = localStorage.getItem("main_id");
      if (flag == "plan") {
        axios
          .post(
            `/admin/product/product_id=${product_id}/flag=${flag}/add-data-to-existing`,
            this.solved_array[0].plan_data[index]
          )
          .then((response) => {
            if (response.data.status == 201) {
              this.$swal.fire({
                // position: "top-end",
                icon: "success",
                title: "Updated",
                showConfirmButton: false,
                timer: 1500,
              });
              this.editList(product_id);
            } else {
              this.$swal.fire({
                title: "failed",
                showConfirmButton: true,
                // timer: 1500,
              });
            }
          });
      } else if (flag == "key") {
        let formdata = new FormData();
        formdata.append(
          "key_points_title",
          this.key_points_array[0].key_points[index].key_points_title
        );
        formdata.append(
          "key_points_text",
          this.key_points_array[0].key_points[index].key_points_text
        );
        formdata.append("key_points_image", this.key_points_image_update);
        axios
          .post(
            `/admin/product/product_id=${product_id}/flag=${flag}/add-data-to-existing`,
            formdata
          )
          .then((response) => {
            if (response.data.status == 201) {
              this.$swal.fire({
                // position: "top-end",
                icon: "success",
                title: "Updated",
                showConfirmButton: false,
                timer: 1500,
              });
              this.editList(product_id);
            } else {
              this.$swal.fire({
                title: "failed",
                showConfirmButton: true,
                // timer: 1500,
              });
            }
          });
      } else if (flag == "feature") {
        axios
          .post(
            `/admin/product/product_id=${product_id}/flag=${flag}/add-data-to-existing`,
            this.features_array[0].features_data[index]
          )
          .then((response) => {
            if (response.data.status == 201) {
              this.$swal.fire({
                // position: "top-end",
                icon: "success",
                title: "Updated",
                showConfirmButton: false,
                timer: 1500,
              });
              this.editList(product_id);
            } else {
              this.$swal.fire({
                title: "failed",
                showConfirmButton: true,
                // timer: 1500,
              });
            }
          });
      }
    },

    save() {
      let url = `/admin/product/store`;
      let formdata = new FormData();
      if (this.product_name === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter product name",
          showConfirmButton: true,
        });
      } else if (this.prod_logo === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter product logo",
          showConfirmButton: true,
        });
      } else if (this.title === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter title",
          showConfirmButton: true,
        });
      } else if (this.description === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter description",
          showConfirmButton: true,
        });
      } else if (this.cover_img === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter cover image",
          showConfirmButton: true,
        });
      } else if (this.features_first_description === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter features description",
          showConfirmButton: true,
        });
      } else if (this.features_second_description === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter features second description",
          showConfirmButton: true,
        });
      } else if (this.feature_image === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter feature image",
          showConfirmButton: true,
        });
      } else if (this.total_users === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter total users",
          showConfirmButton: true,
        });
      } else if (this.key_points_header === "") {
        this.$swal.fire({
          icon: "error",
          title: "Please enter key points header",
          showConfirmButton: true,
        });
      } else {
        formdata.append("product_name", this.product_name);
        formdata.append("title", this.title);
        formdata.append("description", this.description);
        formdata.append("key_points_description", this.key_points_description);
        formdata.append("product_logo", this.prod_logo);
        formdata.append("cover_image", this.cover_img);
        formdata.append(
          "features_first_description",
          this.features_first_description
        );
        formdata.append(
          "features_second_description",
          this.features_second_description
        );
        formdata.append("feature_image", this.feature_image);
        formdata.append("total_users", this.total_users);
        formdata.append("key_points_header", this.key_points_header);
        try {
          axios
            .post(url, formdata)
            .then((response) => {
              localStorage.setItem("product_id", response.data.data.product.id);
              this.product_id = localStorage.getItem("product_id");
              if (response.data.status == 201) {
                this.$swal.fire({
                  icon: "success",
                  title: "Saved",
                  showConfirmButton: true,
                });
              } else {
                this.$swal.fire({
                  title: "failed",
                  showConfirmButton: true,
                });
              }

              setTimeout(function () {
                this.success = "";
              }, 5000);
            })
            .catch((error) => {
              this.loader = false;
            });
        } catch (error) {
          console.log(error);
        }
      }
    },
    addField(value, fieldType, index) {
      if (this.solved_array[index].solved_problem_title != "") {
        fieldType.push({ value: "" });
      }
    },
    skip_plan() {
      this.skip = true;
    },
    removeField(index, fieldType) {
      fieldType.splice(index, 1);
    },

    disable_solved_btn(input) {
      input.disabled = true;
    },

    addKeypointsField(value, fieldType, index) {
      value.key_btn_disabled = true;
      if (
        this.key_points_array[index].key_points_title != "" &&
        this.key_points_array[index].key_points_text != ""
      ) {
        fieldType.push({ value: "" });
      }
    },

    removeKeypointsField(index, fieldType) {
      fieldType.splice(index, 1);
    },

    addFeaturesField(value, fieldType, index) {
      value.feature_btn_disabled = true;
      if (
        this.features_array[index].title != "" &&
        this.features_array[index].description != ""
      ) {
        fieldType.push({ value: "" });
      }
    },

    removeFeaturesField(index, fieldType) {
      fieldType.splice(index, 1);
    },

    addTechField(value, fieldType, index) {
      value.tech_btn_disabled = true;
      if (this.tech_array[index].technologies != "") {
        fieldType.push({ value: "" });
      }
    },

    removeTechField(index, fieldType) {
      fieldType.splice(index, 1);
    },

    key_points_image_func(e) {
      this.key_points_image = e.target.files[0];
      console.log(this.key_points_image);
    },

    solved_image(e) {
      // console.log(index);
      this.solved_problem_image = e.target.files[0];
      // this.solved_problem_image.push(this.$refs.image[index].files[0]);

      console.log(this.solved_problem_image);
    },

    product_logo(e) {
      this.prod_logo = e.target.files[0];
      console.log(this.prod_logo);
    },

    cover_image(e) {
      this.cover_img = e.target.files[0];
      console.log(this.cover_img);
    },

    purpose() {
      try {
        if ($(".summernote").summernote("code") === "") {
          this.$swal.fire({
            title: "Please enter benefits",
            showConfirmButton: true,
            // timer: 1500,
          });
        } else {
          console.log($(".summernote").summernote("code"));
          axios
            .post("/admin/purpose", {
              text: $(".summernote").summernote("code"),
              product_id: this.product_id,
            })
            .then((response) => {
              console.log(response);
              localStorage.setItem("purpose_id", response.data.data.id);
              this.purpose_id = localStorage.getItem("purpose_id");
              setTimeout(function () {
                window.location.reload();
              }, 4000);

              if (response.data.status == 201) {
                this.$swal.fire({
                  // position: "top-end",
                  icon: "success",
                  title: "Completed",
                  showConfirmButton: false,
                  timer: 1500,
                });
              } else {
                this.$swal.fire({
                  title: "failed",
                  showConfirmButton: true,
                  // timer: 1500,
                });
              }
            });
        }
      } catch (error) {
        this.$swal.fire({
          title: "failed",
          showConfirmButton: true,
          // timer: 1500,
        });
      }
    },

    features_save(input_five, features_array, index) {
      if (
        this.features_array[index].title === "" ||
        this.features_array[index].description === ""
      ) {
      } else {
        axios
          .post(`/admin/feature/store`, {
            title: this.features_array[index].title,
            description: this.features_array[index].description,
            product_id: this.product_id,
          })
          .then((response) => {
            console.log(response);
            localStorage.setItem("feature_id", response.data.data.id);
            this.feature_id = localStorage.getItem("feature_id");
            if (response.data.status == 201) {
              this.addFeaturesField(input_five, features_array, index);
              this.$swal.fire({
                // position: "top-end",
                icon: "success",
                title: "Features saved",
                showConfirmButton: false,
                timer: 1500,
              });
            } else {
              this.$swal.fire({
                title: "failed",
                showConfirmButton: true,
                // timer: 1500,
              });
            }
          });
      }
    },

    technology_save(index) {
      try {
        // const tech_list = [];
        console.log(this.tech_array[index].technologies);
        // for (let i = 0; i < this.tech_array.length; i++) {
        // tech_list.push(this.tech_array[in].technologies);
        // }
        // console.log(tech_list);
        // exit();
        axios
          .post("/admin/tech-save", {
            tech: this.tech_array[index].technologies,
            product_id: this.product_id,
          })
          .then((response) => {
            console.log(response);
            localStorage.setItem("tech_id", response.data.data.id);
            this.tech_id = localStorage.getItem("tech_id");
            if (response.data.status == 201) {
              this.$swal.fire({
                // position: "top-end",
                icon: "success",
                title: "Technology saved",
                showConfirmButton: false,
                timer: 1500,
              });
            } else {
              this.$swal.fire({
                title: "failed",
                showConfirmButton: true,
                // timer: 1500,
              });
            }
          });
      } catch (error) {
        this.$swal.fire({
          title: error,
          showConfirmButton: true,
          // timer: 1500,
        });
      }
    },

    key_points_save(input_two, key_points_array, index) {
      let formdata = new FormData();
      if (
        this.key_points_array[index].key_points_title === "" ||
        this.key_points_array[index].key_points_text === ""
      ) {
        // this.$swal.fire({
        //   icon: "error",
        //   title: "Enter missing fields",
        //   showConfirmButton: true,
        //   // timer: 1500,
        // });
      } else {
        formdata.append(
          "key_points_title",
          this.key_points_array[index].key_points_title
        );
        formdata.append(
          "key_points_text",
          this.key_points_array[index].key_points_text
        );
        formdata.append("key_points_image", this.key_points_image);
        formdata.append("product_id", this.product_id);

        axios.post("/admin/key-points/store", formdata).then((res) => {
          console.log(res.data);
          localStorage.setItem("key_point_id", res.data.data.id);
          this.key_point_id = localStorage.getItem("key_point_id");
          if (res.data.status == 201) {
            this.addKeypointsField(input_two, key_points_array, index);
            this.$swal.fire({
              // position: "top-end",
              icon: "success",
              title: "Key Point saved",
              showConfirmButton: false,
              timer: 1500,
            });
          } else {
          }
        });
      }
    },

    greet() {
      window.scrollTo(0, 0);
    },

    editList(id) {
      this.edit = 1;
      // this.form_name="plan"
      localStorage.setItem("main_id", id);
      this.is_editing = true;
      axios.get(`/admin/product/id=${id}/edit`).then((response) => {
        console.log(response.data.data[0]);
        ////update product start
        this.product_main_id = response.data.data[0].id;
        this.product_name = response.data.data[0].product_name;
        this.title = response.data.data[0].title;
        this.fetch_prod_logo = response.data.data[0].product_logo;
        this.description = response.data.data[0].description;
        this.fetch_cover_img = response.data.data[0].cover_image;
        this.features_first_description =
          response.data.data[0].features_description;
        this.fetch_feature_image = response.data.data[0].feature_image;
        this.features_second_description =
          response.data.data[0].features_second_description;
        this.features_second_description =
          response.data.data[0].features_second_description;
        this.total_users = response.data.data[0].total_users;
        this.key_points_header = response.data.data[0].key_points_header;
        // this.key_points_header = response.data.data[0].key_points_header
        ////update product end

        ////update plan
        this.solved_array[0].plan_data = response.data.data[0].plans;
        this.solved_array[0].form_name = "plan";
        // this.solved_array[0].price = response.data.data[0].plans[0].price
        console.log(this.solved_array[0].plan_data);
        this.key_points_array[0].key_points = response.data.data[0].keys;
        // this.key_points_array[0].key_points_title = response.data.data[0].keys[0].key_points_title

        this.features_array[0].features_data = response.data.data[0].features;
        // this.features_array[0].description = response.data.data[0].features[0].description
        this.benefits_id = response.data.data[0].using_purposes[0].id;
        this.using_purpose =
          response.data.data[0].using_purposes[0].using_purpose;
        $(".summernote").summernote("code", this.using_purpose);
      });
    },

    destroy_prototype(id, flag) {
      const main_id = localStorage.getItem("main_id");
      axios
        .post(`/admin/delete-prototype`, {
          id: id,
          flag: flag,
        })
        .then((response) => {
          console.log("res", response);
          if (response.data.status == 201) {
            this.$swal.fire({
              // position: "top-end",
              icon: "success",
              title: "Deleted",
              showConfirmButton: false,
              timer: 1500,
            });
            this.editList(main_id);
          } else {
            this.$swal.fire({
              title: "failed",
              showConfirmButton: true,
              // timer: 1500,
            });
          }
        });
    },

    update(id) {
      console.log(id);
      let formdata = new FormData();
      formdata.append("product_name", this.product_name);
      formdata.append("title", this.title);
      formdata.append("description", this.description);
      formdata.append("key_points_description", this.key_points_description);
      formdata.append("product_logo", this.prod_logo);
      formdata.append("cover_image", this.cover_img);
      formdata.append(
        "features_first_description",
        this.features_first_description
      );
      formdata.append(
        "features_second_description",
        this.features_second_description
      );
      formdata.append("feature_image", this.feature_image);
      formdata.append("total_users", this.total_users);
      formdata.append("key_points_header", this.key_points_header);
      axios
        .post(`/admin/product/product_id=${id}/update`, formdata)
        .then((response) => {
          console.log(response);
          if (response.data.status === 201) {
            this.$swal.fire({
              // position: "top-end",
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500,
            });
            this.prod_logo = "";
            this.cover_img = "";
            this.feature_image = "";
            this.editList(id);
          } else {
            this.$swal.fire({
              title: "failed",
              showConfirmButton: true,
              // timer: 1500,
            });
          }
        });
    },

    update_plan(id, index) {
      console.log(this.solved_array[0].plan_data[index]);
      axios
        .post(`/admin/plan_id=${id}/plan-update`, {
          plan: this.solved_array[0].plan_data[index].plan,
          price: this.solved_array[0].plan_data[index].price,
        })
        .then((response) => {
          // console.log(response)
          if (response.status === 201) {
            this.$swal.fire({
              // position: "top-end",
              icon: "success",
              title: response.message,
              showConfirmButton: false,
              timer: 1500,
            });
            this.editList();
          } else {
            this.$swal.fire({
              title: "failed",
              showConfirmButton: true,
              // timer: 1500,
            });
          }
        });
    },

    key_points_image_update_func(e) {
      this.key_points_image_update = e.target.files[0];
      console.log(this.key_points_image_update);
    },

    key_points_update(id, index) {
      let formdata = new FormData();
      formdata.append(
        "key_points_title",
        this.key_points_array[0].key_points[index].key_points_title
      );
      formdata.append(
        "key_points_text",
        this.key_points_array[0].key_points[index].key_points_text
      );
      formdata.append("key_points_image", this.key_points_image_update);
      axios
        .post(`/admin/key_point_id=${id}/key-point-update`, formdata)
        .then((response) => {
          console.log(response.data);
          if (response.data.status === 201) {
            this.$swal.fire({
              // position: "top-end",
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500,
            });
            this.editList(localStorage.getItem("main_id"));
          } else {
            this.$swal.fire({
              title: "failed",
              showConfirmButton: true,
              // timer: 1500,
            });
          }
        });
    },

    features_update(id, index) {
      axios
        .post(`/admin/feature_id=${id}/feature-update`, {
          title: this.features_array[0].features_data[index].title,
          description: this.features_array[0].features_data[index].description,
        })
        .then((response) => {
          if (response.data.status === 201) {
            this.$swal.fire({
              // position: "top-end",
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500,
            });
            this.editList(localStorage.getItem("main_id"));
          } else {
            this.$swal.fire({
              title: "failed",
              showConfirmButton: true,
              // timer: 1500,
            });
          }
        });
    },

    benefits_update(id) {
      axios
        .post(`/admin/purpose_id=${id}/purpose-update`, {
          purpose: $(".summernote").summernote("code"),
        })
        .then((response) => {
          if (response.data.status === 201) {
            this.$swal.fire({
              // position: "top-end",
              icon: "success",
              title: response.data.message,
              showConfirmButton: false,
              timer: 1500,
            });
            this.editList(localStorage.getItem("main_id"));
          } else {
            this.$swal.fire({
              title: "failed",
              showConfirmButton: true,
              // timer: 1500,
            });
          }
        });
    },

    destroyList(id) {
      axios.get(`/admin/product/delete/${id}`).then((response) => {
        console.log(response);
        if (response.data.status == 201) {
          this.$swal.fire({
            icon: "success",
            title: "Product deleted",
            showConfirmButton: false,
            timer: 1500,
          });
          this.fetchAll();
        } else {
          this.$swal.fire({
            title: "failed",
            showConfirmButton: true,
          });
        }
      });
    },

    disable_button() {
      this.is_editing = false;
      this.edit = 0;
      this.product_name = "";
      this.title = "";
      this.prod_logo = "";
      this.description = "";
      this.cover_img = "";
      this.features_first_description = "";
      this.feature_image = "";
      this.features_second_description = "";
      this.total_users = "";
      this.key_points_header = "";
      // this.key_points_header = response.data.data[0].key_points_header
      ////update product end

      ////update plan
      this.solved_array[0].plan = "";
      this.solved_array[0].price = "";

      this.key_points_array[0].key_points_text = "";
      this.key_points_array[0].key_points_title = "";

      this.features_array[0].title = "";
      this.features_array[0].description = "";
      $(".summernote").summernote("code", "");
    },

    feature_photo(e) {
      this.feature_image = e.target.files[0];
    },

    plan_save(input, solved_array, index) {
      if (
        this.solved_array[index].plan === "" ||
        this.solved_array[index].price === ""
      ) {
      } else {
        axios
          .post("/admin/plan/store", {
            plan: this.solved_array[index].plan,
            price: this.solved_array[index].price,
            product_id: this.product_id,
          })
          .then((response) => {
            console.log(response.data.data.id);
            localStorage.setItem("plan_id", response.data.data.id);
            this.plan_id = localStorage.getItem("plan_id");
            this.addField(input, solved_array, index);
            this.disable_solved_btn(input);
            if (response.data.status == 201) {
              this.$swal.fire({
                icon: "success",
                title: "Plans saved",
                showConfirmButton: false,
                timer: 1500,
              });
            } else {
              this.$swal.fire({
                title: "failed",
                showConfirmButton: true,
              });
            }
            setTimeout(function () {
              this.success = "";
            }, 5000);
          })
          .catch((error) => {});
      }
    },

    fetchAll() {
      axios
        .get(
          `/admin/products?per_page=${this.per_page}&page=${this.pagination.current_page}`
        )
        .then((response) => {
          this.loader = false;
          this.lists = response.data.data;
          this.last_page = response.data.last_page;
          console.log(this.last_page);
        })
        .catch((error) => {});
    },
  },

  created() {
    this.fetchAll();
    localStorage.setItem("product_id", 0);
    localStorage.setItem("plan_id", 0);
    localStorage.setItem("key_point_id", 0);
    localStorage.setItem("feature_id", 0);
    localStorage.setItem("tech_id", 0);
    localStorage.setItem("purpose_id", 0);
    this.product_id = 0;
    this.plan_id = 0;
    this.feature_id = 0;
    this.key_point_id = 0;
    this.tech_id = 0;
    this.purpose_id = 0;
  },
};
</script>

<style scoped>
div {
  letter-spacing: 1px;
  font-family: sans-serif;
}

.btn-edit {
  background: #0093e9;
}

.card-header {
  background-image: linear-gradient(
    to right,
    rgb(242, 112, 156),
    rgb(255, 148, 114)
  );
}

thead {
  /* background: #84a4ff; */
  background-image: linear-gradient(to right, #0093e9, #80d0c7);
  color: white;
  border: none;
}

.card {
  border-top: none;
  width: 62%;
  margin: auto;
}

.card-header {
  border: none;
}

.btn-save {
  background: #5a67ff;
}

.btn-save:hover {
  background: #0093e9;
  transition: 2s ease;
}

.table-striped > tbody > tr:nth-of-type(odd) > * {
  --bs-table-accent-bg: rgb(229 231 255);
  color: var(--bs-table-striped-color);
  border: none;
}
</style>