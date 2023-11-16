
<template>
  <div class="m-container px-4">
    <div class="d-flex justify-content-between pt-3">
      <div class="form-group  col-md-8">
        <label for="usr">
          <div class="text-2 pb-2">Name:</div>
        </label>
        <input type="text" class="form-control rounded-0 " id="usr">
      </div>

    </div>
    <div class="segments-wrapper pt-3">
      <label for="segments-panel">
        <div class="text-2">Definition</div>
      </label>
      <div class="d-flex flex-column mt-2" id="segments-panel">
        <!-- create panel -->
        <div v-for="(elem, key) in  buildData " :key="key" class="mb-3" style="position: relative;">
          <svg height="78px" width="70px" style="position: absolute;z-index: -1;top: -78px;color: rgb(255, 255, 255);"
            v-show="key > 0">
            <line x1="50%" y1="0%" opacity="0.7" x2="50%" y2="100%" style="stroke:#ffffff;stroke-width:2" />
          </svg>
          <div class="p-3 border  border-white shadow-lg rounded-lg   p-4 mb-4  definition-panel">
            <div class="d-flex justify-content-between">
              <div class="col-md-7">
                <select class="p-2 border rounded-0  " v-model="elem.and.id">
                  <option v-for="definition in basicData.definitions" :key="definition.id" :value="definition.id">
                    {{ definition.name }}
                  </option>
                </select>
              </div>
              <div class="">
                <button type="button" class="btn border rounded-0 text-white" @click="removeElement(key)">
                  <svg width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                    <path
                      d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                  </svg>
                </button>
              </div>
            </div>
            <div class="d-flex justify-content-between mt-3 ">
              <div class="d-flex col-md-10">

                <div>
                  <select class="p-2 border rounded-0 " style="width: 90%;margin-right: 10px;"
                    v-model="elem.and.elements[0]">
                    <option v-for="(e, ekey) in getElements(elem.and.id)" :key="ekey" :value="{ ...e }">{{ e.name }}
                    </option>
                  </select>
                </div>

                <div>
                  <select class="p-2 border rounded-0" style="width: 90%;margin-right: 10px;"
                    v-model="elem.and.elements[1]">
                    <option v-for="(e, ekey) in getElement(elem.and.elements[0], 1)" :key="ekey" :value="{ ...e }">{{
                      e.name
                    }}</option>
                  </select>
                </div>

                <div>
                  <input class="p-2 border rounded-0" :type="elem.and.elements[1] ? elem.and.elements[1].type : 'text'"
                    style="width: 90%;margin-right: 10px;" v-model="elem.and.elements[2]"
                    v-if="elem.and.elements[1] && elem.and.elements[1].type !== 'metric'">
                  <select class="p-2 border rounded-0 " style="width: 90%;margin-right: 10px;"
                    v-show="elem.and.elements[1] && elem.and.elements[1].type === 'metric'"
                    v-model="elem.and.elements[2]">
                    <option v-for="(e, ekey) in getElement(elem.and.elements[1], 2)" :key="ekey" :value="e.id">{{
                      e.name }}
                    </option>
                  </select>
                </div>
                <div class="p-2">Type</div>

                <div>
                  <input class="p-2 border rounded-0" style="width: 90%;margin-right: 10px;" disabled
                    :value="elem.and.elements[1].type">
                </div>

              </div>
              <div class="" v-show="elem.or.length === 0">
                <button type="button" class="btn  border rounded-0 text-white" @click="subElement(key, 0)">OR</button>
              </div>
            </div>


            <!-- or panel create -->
            <div v-for="(subelement, subkey) in  elem.or " :key="subkey" class="mt-2">
              <div class="d-flex justify-content-between mt-2 mb-2 ">
                <button type="button" class="btn border rounded-0 text-white" style="height: 40px;">OR</button>
                <svg height="40px" width="98%">
                  <line x1="0" y1="50%" opacity="0.6" x2="100%" y2="50%"
                    style="stroke:rgb(255, 255, 255);stroke-width:.3" />
                </svg>
              </div>
              <div class="d-flex justify-content-between">
                <div class="col-md-7">
                  <select class="p-2 border rounded-0  " v-model="subelement.id">
                    <option v-for="definition in basicData.definitions" :key="definition.id" :value="definition.id">
                      {{ definition.name }}
                    </option>
                  </select>
                </div>
                <div class="">
                  <button type="button" class="btn border rounded-0 text-white" @click="removeElement(key, subkey)">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                      <path
                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="d-flex justify-content-between mt-3 ">
                <div class="d-flex col-md-10">
                  <div class="p-2 text-3">Has</div>
                  <div>
                    <select class="p-2 border rounded-0  " style="width: 90%;margin-right: 10px;"
                      v-model="elem.or[subkey].elements[0]">
                      <option v-for="(e, j) in  getElements(subelement.id)" :key="j" :value="{ ...e }">{{ e.name }}
                      </option>
                    </select>
                  </div>
                  <div>
                    <select class="p-2 border rounded-0  " style="width: 90%;margin-right: 10px;"
                      v-model="elem.or[subkey].elements[1]">
                      <option v-for="(e, j) in  getElement(elem.or[subkey].elements[0])" :key="j" :value="{ ...e }">{{
                        e.name }}
                      </option>
                    </select>
                  </div>
                  <div>
                    <input class="p-2 border rounded-0"
                      :type="elem.or[subkey].elements[1] ? elem.or[subkey].elements[1].type : 'text'"
                      style="width: 90%;margin-right: 10px;" v-model="elem.or[subkey].elements[2]"
                      v-if="elem.or[subkey].elements[1] && elem.or[subkey].elements[1].type !== 'metric'">
                    <select class="p-2 border rounded-0 " style="width: 90%;margin-right: 10px;"
                      v-show="elem.or[subkey].elements[1] && elem.or[subkey].elements[1].type === 'metric'"
                      v-model="elem.or[subkey].elements[2]">
                      <option v-for="(e, ekey) in getElement(elem.or[subkey].elements[1])" :key="ekey" :value="e.id">{{
                        e.name }}
                      </option>
                    </select>
                  </div>
                  <div class="p-2">Type</div>
                  <div>
                    <input class="p-2 border rounded-0" style="width: 90%;margin-right: 10px;" disabled
                      :value="elem.or[subkey].elements[1].type">
                  </div>
                </div>
                <div class="" v-show="elem.or.length !== subkey">
                  <button type="button" class="btn border rounded-0 text-white"
                    @click="subElement(key, subkey)">OR</button>
                </div>
              </div>
            </div>
          </div>
          <button type="button" class="btn border   bg-white rounded-0 " @click="addElement(key)">+ADD</button>
        </div>

        <div class="mb-3" v-show="buildData.length == 0">
          <button type="button" class="btn border   bg-white rounded-0 " @click="addElement(key)">+ADD</button>
        </div>

      </div>
    </div>
    <div class="d-flex p-3 m-bg-info justify-content-end">
      <button type="button" class="btn btn-outline-secondary rounded-0 bg-white">cancel</button>
      <button type="button" class="btn btn-outline-secondary rounded-0 mx-1 bg-dark text-white" @click="updateSegments()">
        Update Segment<svg width="16" style="float:right;margin: 5px;" height="16" fill="currentColor"
          class="bi bi-fast-forward" viewBox="0 0 16 16">
          <path
            d="M6.804 8 1 4.633v6.734L6.804 8Zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692Z" />
          <path
            d="M14.804 8 9 4.633v6.734L14.804 8Zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C8.713 12.69 8 12.345 8 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692Z" />
        </svg>
      </button>
      <button type="button" class="btn btn-outline-secondary rounded-0 mx-1 text-white" v-show="saveData.length > 0"
        @click="clearData()">Clear</button>
      <button type="button" class="btn btn-outline-secondary rounded-0 mx-1 text-white" v-show="saveData.length > 0"
        @click="importData()">Import</button>
    </div>
  </div>
</template>

<script >

export default {
  data() {
    return {
      basicData: {
        "definitions": [
          {
            "id": "prop",
            "name": "Properties about someone",
            "value": "text_edit",
            "elements": [
              { "id": "prop_birthday", "name": "Birthday", "type": "date" },
              { "id": "prop_age", "name": "Age", "type": "number" },
              { "id": "prop_zip_code", "name": "Zip Code", "type": "string" }
            ]
          },
          {
            "id": "met",
            "name": "When someone has done (or not done)",
            "value": "metric",
            "elements": [
              { "id": "metric_bounced_email", "name": "Bounced an email", "type": "metric" },
              { "id": "metric_click_email", "name": "Clicked an email", "type": "metric" },
              { "id": "metric_open_push", "name": "Opened a push notification", "type": "metric" },
            ]
          },
          {
            "id": "in_list",
            "name": "When someone is in a list",
            "value": "list",
            "elements": [
              { "id": "list_1", "name": "One black list" },
              { "id": "list_2", "name": "Colectivo test2" },
              { "id": "list_3", "name": "COS test" }
            ]
          },
          {
            "id": "not_in_list",
            "name": "When someone is not in a list",
            "elements": [
              { "id": "list_1", "name": "One black list" },
              { "id": "list_2", "name": "Colectivo test2" },
              { "id": "list_3", "name": "COS test" }
            ]
          }
        ],
        "types": [
          {
            "id": "date",
            "elements": [
              { "id": "date_eq", "name": "Equals to" }, { "id": "date_gr", "name": "Greater than" }, { "id": "date_gr_eq", "name": "Greater or equals to" }
            ],
            "display": "text_edit_date"
          },
          {
            "id": "number",
            "elements": [
              { "id": "num_eq", "name": "Equals to" }, { "id": "num_gr", "name": "Greater than" }, { "id": "num_gr_eq", "name": "Greater or equals to" }
            ],
            "display": "text_edit_number"
          },
          {
            "id": "string",
            "elements": [
              { "id": "str_eq", "name": "Equals to" }, { "id": "str_like", "name": "Contains" }, { "id": "str_starts", "name": "starts" }
            ],
            "display": "text_edit"
          },
          {
            "id": "metric",
            "elements": [
              { "id": "met_alo", "name": "At least once" }, { "id": "met_eq", "name": "Equals to" },
              { "id": "met_zero", "name": "Zero times" }, { "id": "met_gt", "name": "Is greater than" }
            ],
            "display": "dropdown"
          }
        ],
      }
      ,
      buildData: [],
      name: "",
      selectTagValue: "",
      tags: [],
      saveData: []
    }
  },
  computed: {

  },
  updated() {
  },
  watch: {
  },
  mounted() {
    this.addElement(-1)
  },
  methods: {
    getElements(_id) {
      var definition = this.basicData.definitions.find(({ id }) => id === _id);
      var data = definition ? definition.elements : [];
      return [...data]
    },
    getElement(element, c) {
      var elements = [];
      console.log(element, c)

      if (element) {
        const type = this.basicData.types.find(({ id }) => id === element.type);
        console.log(type)
        if (type) {
          elements = type.elements.map(item => {
            return {
              id: item.id,
              name: item.name,
              type: type.id
            };
          });
        } else {
          this.basicData.types.forEach(type => {
            type.elements.forEach(item => {
              elements.push({
                id: item.id,
                name: item.name,
                type: type.id
              });
            });
          });
        }
      }
      console.log(elements)
      return elements

    },
    addElement(index) {
      var data = { and: { id: this.basicData.definitions[0].id, elements: [] }, or: [] }
      data.and.elements[0] = this.getElements(data.and.id)[0];
      data.and.elements[1] = this.getElement(data.and.elements[0])[0];
      data.and.elements[2] = "";
      this.buildData.splice(index + 1, 0, { ...data });
    },
    subElement(andIndex, orIndex) {
      var data = { id: this.basicData.definitions[0].id, elements: [] };
      data.elements[0] = this.getElements(data.id)[0];
      data.elements[1] = this.getElement(data.elements[0])[0];
      data.elements[2] = ""
      this.buildData[andIndex].or.splice(orIndex + 1, 0, { ...data });
    },
    removeElement(index, orIndex) {
      if (typeof orIndex !== 'undefined') {
        this.buildData[index].or.splice(orIndex, 1);
      } else {
        this.buildData.splice(index, 1);
      }
    },
    updateSegments() {
      this.saveData = this.buildData;
      console.log(JSON.stringify(this.buildData))
    },
    setBasicData(data) {
      if (data.definitions && data.types) {
        this.basicData = data;
      } else {
        console.log(data)
      }
    },
    importData() {
      this.buildData = this.saveData
    },
    clearData() {
      this.buildData = [];
      this.addElement(-1)
    }
  }
}
</script>
<style>
.col-md-8 {
  flex: 0 0 66.666667%;
  max-width: 66.666667%;
}

.p-5 {
  padding: 48px;
}

.p-4 {
  padding: 1.5rem !important;
}

.pt-3 {
  padding-top: 1rem !important;
}

.px-4 {
  padding-left: 1.5rem !important;
  padding-right: 1.5rem !important;

}

.mb-4 {
  margin-bottom: 1.5rem !important;
}

.shadow-lg {

  box-shadow: 0 1rem 3rem rgba(0, 0, 0, .175) !important;
}

.rounded-lg {
  border-radius: 0.3rem !important
}

.pt-5 {
  padding-top: 48px;
}

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}

.justify-content-end {
  justify-content: end;
}

.btn {

  display: inline-block;
  font-weight: 400;
  color: #212529;
  text-align: center;
  vertical-align: middle;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
  background-color: transparent;
  border: 1px solid transparent;
  padding: 0.375rem 0.75rem;
  font-size: 1rem;
  line-height: 1.5;
  border-radius: 0.25rem;
  transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.btn-outline-secondary {
  color: #6c757d;
  border-color: #6c757d;
}

.border {
  border-width: 1px;
  border-color: white;
}

.rounded-0 {
  border-radius: 0;
}

.bg-white {
  background-color: white;
}

.text-white {
  color: white;
}

.mx-1 {
  margin-left: 10px;
}

.bg-dark {
  background-color: #343a40;
}

.form-group {
  margin-bottom: 1rem;
}

.form-control {
  display: block;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  font-size: .7rem;
  font-weight: 400;
  line-height: 1.3;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: 0.15rem;
  transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

.flex-column {
  flex-direction: column;
}

.mt-2 {
  margin-top: 20px;
}

.mb-3 {
  margin-bottom: 1rem !important;
}

.p-2 {
  padding: 0.5rem !important;
}

.pb-2 {
  padding-bottom: 0.5rem !important;

}

.m-container {
  width: 100%;
  height: 100%;
  /* background-color: rgba(54, 54, 54, 0.459); */
}

.definition-panel {
  opacity: 1;
  animation-name: fadein;
  animation-duration: .4s;
  animation-direction: reverse;
  animation-iteration-count: 1;
  transition: height 0.3s ease-in;
  background: rgb(71 71 71 / 46%);
}

.m-bg-info {
  background-color: rgba(202, 201, 201, 0.356);
}

.text-2 {
  font-size: 20px;
  font-weight: bold;
}

.text-3 {
  font-size: 14px;
  font-weight: bold;
}



@keyframes fadein {
  to {
    opacity: 0.2;
  }
}
</style>
