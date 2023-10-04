<template>
  <div>
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
        <button class="btn btn-primary">Add Jobs</button>
      </div>
      <div class="col-md-6 mt-4">
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
            <h4 class="card-title text-white text-center" style="margin: auto">
              {{ this.is_editing ? "Update Jobs" : "Create Jobs" }}
            </h4>
          </div>
          <div class="card-body">
            <form v-if="!isJob" @submit.prevent="save()" method="post">
              <div class="form-group">
                <label for="title">Position</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="position"
                  required
                />
                <div class="text-danger" v-if="positionError && position == ''">
                  {{ positionError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Slug</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="slug"
                  required
                />
                <div class="text-danger" v-if="slugError && slug == ''">
                  {{ this.slugError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Summary</label><br />
                <textarea class="form-control" v-model="summary"></textarea>
              </div>
              <div class="form-group">
                <label for="title">Cover</label><br />
                <input
                  type="file"
                  class="form-control"
                  @change="image_handler"
                  required
                />
                <img
                  v-if="is_editing"
                  style="width: 20%"
                  :src="$base + cover_img_view_during_edit"
                  alt=""
                />
                <div
                  class="text-danger"
                  v-if="
                    this.cover_imageError && cover_image == '' && !is_editing
                  "
                >
                  {{ this.cover_imageError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Education Requirement</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="edu_requirement"
                  required
                />
                <div
                  class="text-danger"
                  v-if="edu_requirementError && edu_requirement == ''"
                >
                  {{ edu_requirementError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Salary</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="salary"
                  required
                />
                <div class="text-danger" v-if="salaryError && salary == ''">
                  {{ this.salaryError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Vacancy</label><br />
                <input
                  type="number"
                  class="form-control"
                  v-model="vacancy"
                  required
                />
                <div
                  class="text-danger"
                  v-if="this.vacancyError && vacancy == ''"
                >
                  {{ this.vacancyError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Employment Status</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="employment_status"
                  required
                />
                <div
                  class="text-danger"
                  v-if="this.employment_statusError && employment_status == ''"
                >
                  {{ this.employment_statusError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Office Time</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="office_time"
                  required
                />
                <div
                  class="text-danger"
                  v-if="this.office_timeError && office_time == ''"
                >
                  {{ this.office_timeError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Location</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="location"
                  required
                />
                <div
                  class="text-danger"
                  v-if="this.locationError && location == ''"
                >
                  {{ this.locationError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Office Days</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="office_days"
                  required
                />
                <div
                  class="text-danger"
                  v-if="this.office_daysError && office_days == ''"
                >
                  {{ this.office_daysError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Experience Requirements</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="experience_req"
                />
                <div
                  class="text-danger"
                  v-if="this.experience_reqError && experience_req == ''"
                >
                  {{ this.experience_reqError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Application Deadline</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="app_deadline"
                  required
                />
                <div
                  class="text-danger"
                  v-if="this.app_deadlineError && app_deadline == ''"
                >
                  {{ this.app_deadlineError }}
                </div>
              </div>
              <div class="form-group">
                <label for="title">Applying URL</label><br />
                <input
                  type="text"
                  class="form-control"
                  v-model="applying_url"
                  required
                />
                <div
                  class="text-danger"
                  v-if="this.applying_urlError && applying_url == ''"
                >
                  {{ this.applying_urlError }}
                </div>
              </div>
              <div>
                <button
                  type="button"
                  class="btn btn-block btn-save text-white"
                  @click="saveOrUpdate()"
                >
                  {{ is_editing ? "Update and next" : "Save and next" }}
                </button>
              </div>
            </form>
            <div v-if="isJob && !isResponsibility && !isRequired">
              <div v-for="(data, index) in responsibility_array" :key="index">
                <!-- <form method="post"> -->
                <div class="form-group">
                  <label for="title">Responsibility</label><br />
                  <input
                    type="text"
                    class="form-control"
                    required
                    v-model="data.responsibility"
                  />
                  <div
                    class="text-danger"
                    v-if="data.responsibilityError && data.responsibility == ''"
                  >
                    {{ data.responsibilityError }}
                  </div>
                </div>

                <!-- </form> -->
              </div>
              <div v-show="responsibility_array.length > 1">
                <button
                  @click="
                    removeField(
                      responsibility_array.length - 1,
                      responsibility_array
                    )
                  "
                  type="button"
                >
                  <img
                    style="margin-left: 83%; position: absolute; border: none"
                    :src="$base + 'assets/icons/minus.gif'"
                    alt=""
                  />
                </button>
              </div>
              <div style="display: flex; justify-content: center">
                <button
                  type="button"
                  class="btn btn-back text-white mx-1"
                  @click="back_responsibility(1)"
                >
                  go back
                </button>
                <button
                  @click="saveOrUpdate_responsibility"
                  type="button"
                  class="btn btn-save text-white mx-1"
                >
                  {{ is_editing ? "Update and next" : "Save and next" }}
                </button>
              </div>
              <button
                type="button"
                class="btn"
                @click="addField(data, responsibility_array)"
              >
                <img :src="$base + 'assets/icons/plus.gif'" alt="" />
              </button>
            </div>
            <div v-if="isJob && isResponsibility && !isRequired">
              <div v-for="(data, index) in require_array" :key="index">
                <!-- <form method="post"> -->
                <div class="form-group">
                  <label for="title">Requirements</label><br />
                  <input
                    type="text"
                    class="form-control"
                    v-model="data.requirement"
                    required
                  />
                  <div
                    class="text-danger"
                    v-if="data.requireError && data.requirements == ''"
                  >
                    {{ data.requireError }}
                  </div>
                </div>

                <!-- </form> -->
              </div>
              <div v-show="require_array.length > 1">
                <button
                  @click="removeField(require_array.length - 1, require_array)"
                  type="button"
                >
                  <img
                    style="margin-left: 83%; position: absolute; border: none"
                    :src="$base + 'assets/icons/minus.gif'"
                    alt=""
                  />
                </button>
              </div>
              <div style="display: flex; justify-content: center">
                <button
                  type="button"
                  class="btn btn-back text-white mx-1"
                  @click="back_responsibility(2)"
                >
                  go back
                </button>
                <button
                  @click="saveOrUpdate_requirements"
                  type="button"
                  class="btn btn-save text-white mx-1"
                >
                  {{ is_editing ? "Update and next" : "Save and next" }}
                </button>
              </div>
              <button
                type="button"
                class="btn"
                @click="addField(data, require_array)"
              >
                <img :src="$base + 'assets/icons/plus.gif'" alt="" />
              </button>
            </div>
            <div v-if="isRequired">
              <div v-for="(data, index) in additional_array" :key="index">
                <!-- <form method="post"> -->
                <div class="form-group">
                  <label for="title">Additional</label><br />
                  <input
                    type="text"
                    class="form-control"
                    v-model="data.additional"
                    required
                  />
                  <div
                    class="text-danger"
                    v-if="data.additionalError && data.additional == ''"
                  >
                    {{ data.additionalError }}
                  </div>
                </div>

                <!-- </form> -->
              </div>
              <div v-show="additional_array.length > 1">
                <button
                  @click="
                    removeField(additional_array.length - 1, additional_array)
                  "
                  type="button"
                >
                  <img
                    style="margin-left: 83%; position: absolute; border: none"
                    :src="$base + 'assets/icons/minus.gif'"
                    alt=""
                  />
                </button>
              </div>
              <div style="display: flex; justify-content: center">
                <button
                  type="button"
                  class="btn btn-back text-white mx-1"
                  @click="back_responsibility(3)"
                >
                  go back
                </button>
                <button
                  @click="saveOrUpdate_additional"
                  type="button"
                  class="btn btn-save text-white mx-1"
                >
                  {{ is_editing ? "Update and Finish" : "Save and Finish" }}
                </button>
              </div>
              <button
                type="button"
                class="btn"
                @click="addField(data, additional_array)"
              >
                <img :src="$base + 'assets/icons/plus.gif'" alt="" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5 d-flex justify-content-center">
      <div class="col-md-12">
        <h4>Job List</h4>
        <table class="table table-striped text-center">
          <thead>
            <tr>
              <th>No.</th>
              <th>Job title</th>
              <th>Application Deadline</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody v-if="lists.length > 0">
            <tr v-for="(list, index) in lists" :key="index">
              <td style="vertical-align: middle; font-weight: 500">
                {{ index + 1 }}.
              </td>

              <td style="vertical-align: middle; font-weight: 500">
                {{ list.position }}
              </td>

              <td style="vertical-align: middle">
                {{ list.app_deadline }}
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
                <h3 class="text-center">Job is empty...!</h3>
              </td>
            </tr>
          </tbody>
        </table>
        <pagination-component
          v-if="last_page > 1 && pagination.current_page !== 0"
          :pagination="pagination"
          :offset="5"
          @paginate="fetchAll"
        />
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { exit } from "process";
export default {
  data() {
    return {
      is_editing: false,
      loader: false,
      lists: [],
      position: "",
      slug: "",
      cover_image: "",
      cover_img_view_during_edit: "",
      summary: "",
      edu_requirement: "",
      salary: "",
      published_on: "",
      vacancy: "",
      employment_status: "",
      office_time: "",
      location: "",
      office_days: "",
      experience_req: "",
      app_deadline: "",
      applying_url: "",
      isJob: false,
      isResponsibility: false,
      isRequired: false,
      responsibility_array: [
        {
          responsibility: "",
          responsibilityError: "",
        },
      ],

      require_array: [
        {
          requirement: "",
          requireError: "",
        },
      ],
      additional_array: [
        {
          additional: "",
          additionalError: "",
        },
      ],
      // pagination
      lists: [],
      per_page: 5,
      last_page: "",
      pageOfItems: [],
      pagination: {
        current_page: 1,
      },

      // form 1 error handling variables
      positionError: "",
      slugError: "",
      edu_requirementError: "",
      salaryError: "",
      vacancyError: "",
      employment_statusError: "",
      office_timeError: "",
      locationError: "",
      office_daysError: "",
      experience_reqError: "",
      app_deadlineError: "",
      applying_urlError: "",
      cover_imageError: "",

      // form 2 error handling variables
      responsibilityError: "",

      // form 3 error handling variables
      requirementError: "",

      // form 4 error handling variables
      additionalError: "",
    };
  },
  methods: {
    disable_button() {
      localStorage.setItem("job_id", 0);
      this.is_editing = false;
      window.location.reload();
    },

    image_handler(e) {
      this.cover_image = e.target.files[0];
    },
    fetchAll() {
      // this.loader = true;

      this.job_id = localStorage.getItem("job_id");
      axios
        .get(
          `/admin/jobs-lists?per_page=${this.per_page}&page=${this.pagination.current_page}`
        )
        .then((response) => {
          this.loader = false;
          this.lists = response.data.data.data;
          this.last_page = response.data.data.last_page;
          console.log(response);
        })
        .catch((error) => {});
    },

    update_image(e) {
      this.replace_image = e.target.files[0];
      console.log(this.replace_image);
    },
    update(id, album_id) {
      let formData = new FormData();
      formData.append("images", this.replace_image);
      formData.append("id", id);
      axios.post("/admin/gallery/update-image", formData).then((res) => {
        alert("updated");
        this.editList(album_id);
      });
    },

    get_img_id(id, album_id) {
      console.log(album_id);
      confirm("Are you sure?");
      axios
        .get(`/admin/gallery/delete-image/${id}`)
        .then((response) => {
          this.editList(album_id);
          alert("Deleted");
        })
        .catch((error) => {});
    },

    image_handler(e) {
      this.cover_image = e.target.files[0];
      console.log(this.cover_image);
    },

    greet() {
      window.scrollTo(0, 0);
    },

    addField(data, array) {
      array.push({ data: "" });
    },

    saveOrUpdate() {
      try {
        let url;
        this.loader = true;
        url = `/admin/jobs/store`;
        // }
        if (this.position == "") {
          this.positionError = "Enter position";
          this.loader = false;
        } else if (this.slug == "") {
          this.slugError = "Enter slug";
          this.loader = false;
        } else if (this.cover_image == "" && !this.is_editing) {
          this.cover_imageError = "Select cover image";
          this.loader = false;
        } else if (this.edu_requirement == "") {
          this.edu_requirementError = "Enter education requirements";
          this.loader = false;
        } else if (this.salary == "") {
          this.salaryError = "Enter salary";
          this.loader = false;
        } else if (this.vacancy == "") {
          this.vacancyError = "Enter vacancy number";
          this.loader = false;
        } else if (this.employment_status == "") {
          this.employment_statusError = "Enter employment status";
          this.loader = false;
        } else if (this.office_time == "") {
          this.office_timeError = "Enter office time";
          this.loader = false;
        } else if (this.location == "") {
          this.locationError = "enter location";
          this.loader = false;
        } else if (this.office_days == "") {
          this.office_daysError = "Enter office days";
          this.loader = false;
        } else if (this.app_deadline == "") {
          this.app_deadlineError = "Enter deadline";
          this.loader = false;
        } else if (this.applying_url == "") {
          this.applying_urlError = "Enter applying url";
          this.loader = false;
        } else {
          let formdata = new FormData();
          formdata.append("job_id", localStorage.getItem("job_id"));
          formdata.append("position", this.position);
          formdata.append("slug", this.slug);
          formdata.append("summary", this.summary);
          formdata.append("edu_requirement", this.edu_requirement);
          formdata.append("salary", this.salary);
          formdata.append("published_on", this.published_on);
          formdata.append("vacancy", this.vacancy);
          formdata.append("employment_status", this.employment_status);
          formdata.append("office_time", this.office_time);
          formdata.append("location", this.location);
          formdata.append("office_days", this.office_days);
          formdata.append("experience_req", this.experience_req);
          formdata.append("app_deadline", this.app_deadline);
          formdata.append("applying_url", this.applying_url);
          formdata.append("cover_image", this.cover_image);
          formdata.append("is_editing", this.is_editing);
          // }
          axios.post(url, formdata).then((response) => {
            console.log(response);
            if (response.data.status == 201) {
              this.loader = false;
              localStorage.setItem("job_id", response.data.data.id);
              this.isJob = true;
              this.isResponsibility = false;
              this.isRequired = false;
            } else {
              this.$swal.fire({
                title: "failed",
                showConfirmButton: true,
              });
            }
          });
        }
      } catch (error) {
        console.log(error);
      }
    },

    removeField(index, data) {
      data.splice(index, 1);
    },

    back_responsibility(flag) {
      if (flag == 1) {
        this.isJob = false;
        this.isResponsibility = true;
      } else if (flag == 2) {
        this.isJob = true;
        this.isResponsibility = false;
        this.isRequired = false;
      } else if (flag == 3) {
        this.isJob = true;
        this.isResponsibility = true;
        this.isRequired = false;
      }
    },

    saveOrUpdate_responsibility() {
      let job_id = localStorage.getItem("job_id");
      try {
        axios
          .post(
            `/admin/job_id=${job_id}/responsibility-save`,
            this.responsibility_array
          )
          .then((response) => {
            console.log(response);

            if (response.data.status == 201) {
              this.isJob = true;
              this.isResponsibility = true;
              this.isRequired = false;
            }
          })
          .catch((err) => {
            console.log(err);
            if (err) {
              this.responsibility_array[0].responsibilityError =
                "Responsibility required";
            }
          });
      } catch (err) {
        console.log(err);
      }
    },

    saveOrUpdate_requirements() {
      let job_id = localStorage.getItem("job_id");
      axios
        .post(`/admin/job_id=${job_id}/requirements-save`, this.require_array)
        .then((response) => {
          console.log(response);
          if (response.data.status == 201) {
            this.isRequired = true;
          }
        })
        .catch((err) => {
          console.log(err);
          if (err) {
            this.require_array[0].requireError = "Requirements required";
          }
        });
    },

    saveOrUpdate_additional() {
      let job_id = localStorage.getItem("job_id");
      axios
        .post(`/admin/job_id=${job_id}/additional-save`, this.additional_array)
        .then((response) => {
          console.log(response.data.status);
          if (response.data.status == 201) {
            localStorage.setItem("job_id", 0);
            window.location.reload();
          }
        })
        .catch((err) => {
          console.log(err);
          if (err) {
            this.additional_array[0].additionalError =
              "Additional information required";
          }
        });
    },

    editList(list_id) {
      // console.log(list_id)
      (this.loader = true),
        (this.is_editing = true),
        (this.isJob = false),
        (this.isResponsibility = false),
        (this.isRequired = false),
        (this.titleError = ""),
        (this.temporary_id = list_id);

      axios
        .get(`/admin/jobs/edit/${this.temporary_id}`)
        .then((response) => {
          console.log(response.data.data);
          this.loader = false;
          localStorage.setItem("job_id", response.data.data.id);
          this.position = response.data.data.position;
          this.slug = response.data.data.slug;
          this.cover_img_view_during_edit = response.data.data.thumbnail;
          this.summary = response.data.data.summary;
          // console.log(this.gallery_images);
          this.edu_requirement = response.data.data.edu_requirement;
          this.salary = response.data.data.salary;
          this.published_on = response.data.data.published_on;
          this.vacancy = response.data.data.vacancy;
          this.employment_status = response.data.data.employment_status;
          this.office_days = response.data.data.office_days;
          this.office_time = response.data.data.office_time;
          this.location = response.data.data.location;
          this.experience_req = response.data.data.experience_req;
          this.app_deadline = response.data.data.app_deadline;
          // console.log(this.gallery_images);
          this.applying_url = response.data.data.applying_url;

          // responsibility get as an array
          this.responsibility_array = response.data.data.responsibilities;

          // requirement get as an array
          this.require_array = response.data.data.requirements;
          console.log(this.require_array);
          // additional get as an array
          this.additional_array = response.data.data.additionals;
        })
        .catch((error) => {});
    },
    destroyList(list_id) {
      this.loader = true;
      axios.get(`/admin/jobs/delete/${list_id}`).then((response) => {
        this.loader = false;
        this.is_editing = false;
        this.fetchAll();
        this.$swal.fire({
          icon: "error",
          text: "Deleted",
        });
        this.album_caption = "";
        (this.image_caption = ""), (this.title = "");
        this.images = [];
        this.image_Error = "";
        // this.image_caption = "";
        this.image_caption_Error = "";
        this.title_Error = "";
      });
    },
  },
  mounted() {
    this.is_editing = false;
    this.fetchAll();
    localStorage.setItem("job_id", 0);
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
}

.card-header {
  border: none;
}

.btn-save {
  background: #5a67ff;
}

.btn-back {
  background: cadetblue;
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
