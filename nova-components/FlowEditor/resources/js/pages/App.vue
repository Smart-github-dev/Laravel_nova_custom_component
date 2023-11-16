<template>
  <div class="home-container" id="flowy-container">
    <div class="side-bar" v-show="!editStatus">
      <h2>ACTIONS</h2>
      <div class="block-wrapper">
        <div class="blockelem create-flowy noselect">
          <input type="hidden" name="blockelemtype" class="blockelemtype" value="email">
          <div class="blockin">
            <div class="blockico">
              <img src="./images/email.svg">
            </div>
            <div class="blocktitle">EMAIL visitor</div>
          </div>
        </div>
        <div class="blockelem create-flowy noselect">
          <input type="hidden" name="blockelemtype" class="blockelemtype" value="sms">
          <div class="blockin">
            <div class="blockico">
              <img src="./images/sms.svg">
            </div>
            <div class="blocktitle">SMS visitor</div>
          </div>
        </div>
        <div class="blockelem create-flowy noselect">
          <input type="hidden" name="blockelemtype" class="blockelemtype" value="profile">
          <div class="blockin">
            <div class="blockico">
              <img src="./images/user.svg">
            </div>
            <div class="blocktitle">Profile visitor</div>
          </div>
        </div>
        <div class="blockelem create-flowy noselect">
          <input type="hidden" name="blockelemtype" class="blockelemtype" value="webhook">
          <div class="blockin">
            <div class="blockico">
              <img src="./images/webhook.svg">
            </div>
            <div class="blocktitle">WebHook</div>
          </div>
        </div>
      </div>
      <h2>TIMING</h2>
      <div class="block-wrapper">
        <div class="blockelem create-flowy noselect">
          <input type="hidden" name="blockelemtype" class="blockelemtype" value="time">
          <div class="blockin">
            <div class="blockico">
              <img src="./images/time.svg">
            </div>
            <div class="blocktitle">TIME</div>
          </div>
        </div>
        <div class="blockelem " hidden>
          <div class="email-blocky blocky">
            <div class="blocky-top">
              <div class="blockico">
                <img src="./images/email.svg">
              </div>
              <div class="blockycontainer">
                <div class="blockytitle">
                  ompiles and minifies
                </div>
                <div class="blockycontent">
                  Compiles and hot-reloads for development
                </div>
              </div>
              <div class="blockymore">
                <img src="./images/more.svg">
              </div>
            </div>
            <div class="blocky-bottom">
              <div class="filter-btn"><img src="./images/closeleft.svg"></div>
              <div class="action-btns">
                <img src="./images/email.svg">
                <img src="./images/heart.svg">
                <img src="./images/time.svg">
              </div>
            </div>
          </div>
        </div>
        <div class="blockelem " hidden>
          <div class="sms-blocky blockyWrapper">
            <div class="blockico">
              <img src="./images/sms.svg">
            </div>
            <div class="blockycontainer">
              <div class="blockytitle">
                ompiles and minifies
              </div>
              <div class="blockycontent">
                Compiles and hot-reloads for development
              </div>
            </div>
            <div class="blockymore">
              <img src="./images/more.svg">
            </div>
          </div>
        </div>
      </div>
      <br>
      <button class="m-btn" @click="removeblocks">Delete Blocks</button>
      <br>
      <button class="m-btn" @click="importData">import</button>
      <br>

      <button class="m-btn" @click="output">Submit</button>
    </div>
    <div class="" v-bind:class="!editStatus ? 'propwrap' : 'propwrap expanded'">
      <div class="edit-close-btn" @click="closeEditPanel">
        <img src="./images/close.svg">
      </div>
      <div class="properties" v-show="editaction == 'email'">
        <div class="label">Email template</div>
        <select class="dropme" v-model="emailtemp">
          <option style="width: 100%;" v-for="temp in emailtemplates" :value="temp" :key="temp.title">
            {{ getKeepText(temp.title) }}</option>
        </select>
      </div>
      <div class="properties" v-show="editaction == 'sms'">
        <div class="label">SMS template</div>
        <select v-model="smstemp" class="dropme">
          <option v-for="temp in smstemplates" :value="temp" :key="temp.title">{{ getKeepText(temp.title) }}</option>
        </select>
      </div>
      <div class="properties" v-show="editaction == 'profile'">
        <div class="label">Profile template</div>
        <select v-model="profiletemp" class="dropme">
          <option v-for="temp in profiletemplates" :value="temp" :key="temp.title">{{ getKeepText(temp.title) }}</option>
        </select>
      </div>
      <div class="properties" v-show="editaction == 'webhook'">
        <div class="label">WebHook LINK</div>
        <input type="text" class="dropme" v-model="webhook">
      </div>
      <div class="properties" v-show="editaction == 'time'">
        <div class="label">Time setting</div>
        <input type="text" class="dropme" v-model="time">
      </div>
      <div class="m-btn-group">
        <button class="m-btn" @click="closeEditPanel">cancel</button>
        <button class="m-btn" @click="savedata">save</button>
      </div>
    </div>

    <div id="flowy-canvas">
    </div>
  </div>
</template>

<script >
import flowy from '../flowy';

export default {
  data() {
    return {
      flowyData: {},
      tempblock2: null,
      tempblock: null,
      blockin: null,
      noinfo: false,
      aclick: false,
      editStatus: false,
      editaction: "",
      emailtemp: {},
      smstemp: {},
      profiletemp: {},
      emailtemplates: [{ title: "Lodash, Moment, Axios, Async..", content: "these are useful Javascript libraries that you'll want to utilise in many of your Vue.js apps." },
      { title: "You also may want to run", content: "your app in different environments to allow server rendering." },
      { title: "The naive way to add a library to your project is to make it a global variable by attaching it to the  ", content: "Unless you find an easy and robust way to include those Javascript libraries across your components and module files they're going to be a nuisance!" }
      ],
      smstemplates: [{ title: "Lodash, Moment, Axios, Async..", content: "these are useful Javascript libraries that you'll want to utilise in many of your Vue.js apps." },
      { title: "You also may want to run", content: "your app in different environments to allow server rendering." },
      { title: "The naive way to add a library to your project is to make it a global variable by attaching it to the  ", content: "Unless you find an easy and robust way to include those Javascript libraries across your components and module files they're going to be a nuisance!" }
      ],
      profiletemplates: [{ title: "Lodash, Moment, Axios, Async..", content: "these are useful Javascript libraries that you'll want to utilise in many of your Vue.js apps." },
      { title: "You also may want to run", content: "your app in different environments to allow server rendering." },
      { title: "The naive way to add a library to your project is to make it a global variable by attaching it to the  ", content: "Unless you find an easy and robust way to include those Javascript libraries across your components and module files they're going to be a nuisance!" }
      ],
      webhook: "http:\\",
      time: ""
    }
  },
  mounted() {
    flowy(document.getElementById("flowy-canvas"), this.drag, this.release, this.snapping)
    document.addEventListener("mousedown", this.beginTouch, false);
    document.addEventListener("mousemove", this.checkTouch, false);
    document.addEventListener("mouseup", this.doneTouch, false);
    this.addEventListenerMulti("touchstart", this.beginTouch, false, ".block");
  },
  methods: {
    snapping(drag) {
      var type = drag.querySelector(".blockelemtype").value;
      var blockin = drag.querySelector(".blockin");
      this.tempblock = drag;

      switch (type) {
        case "email":
          blockin.parentNode.removeChild(blockin);
          var emailblock = document.getElementsByClassName("email-blocky")[0].cloneNode(true);
          drag.appendChild(emailblock);

          break;
        case "sms":
          blockin.parentNode.removeChild(blockin);
          var smsblock = document.getElementsByClassName("sms-blocky")[0].cloneNode(true);
          drag.appendChild(smsblock)

          break;
        case "profile":
          break;
        case "webhook":
          drag.querySelector(".blocktitle").innerHTML = "here is Link"

          break;
        case "time":

          drag.querySelector(".blocktitle").innerHTML = "Wait 0 hours"
          break;
      }

      return true;
    },
    drag(block) {
      block.classList.add("blockdisabled");
      this.tempblock2 = block;
    },
    release() {
      if (this.tempblock2) {
        this.tempblock2.classList.remove("blockdisabled");
      }
    },
    importData() {
      try {
        flowy.deleteBlocks()
        flowy.import(JSON.parse(this.flowyData))
      } catch (error) {
        console.log(error)
      }
    },
    output() {

      this.flowyData = JSON.stringify(flowy.output());
      console.log(this.flowyData);
    },
    addEventListenerMulti(type, listener, capture, selector) {
      var nodes = document.querySelectorAll(selector);
      for (var i = 0; i < nodes.length; i++) {
        nodes[i].addEventListener(type, listener, capture);
      }
    },
    beginTouch(event) {
      this.aclick = true;
      this.noinfo = false;
      if (event.target.closest(".create-flowy")) {
        this.noinfo = true;
      }
    },
    checkTouch() {
      if (this.aclick)
        this.aclick = false;
    },
    closeEditPanel() {
      if (this.editStatus) {
        this.editStatus = false;
        this.tempblock.classList.remove("selectedblock");
      }
    },
    doneTouch(event) {
      if (event.type === "mouseup" && this.aclick && !this.noinfo) {
        if (event.target.closest(".block") && !event.target.closest(".block").classList.contains("dragging")) {



          var type = event.target.closest(".block").querySelector(".blockelemtype").value;

          if (!this.editStatus || this.editaction !== type) {
            this.editaction = type;

            if (this.editStatus) {
              this.editStatus = false;
              this.tempblock.classList.remove("selectedblock");
            }
            setTimeout(() => {
              this.editStatus = true;
            }, 100);


            this.tempblock = event.target.closest(".block");
            this.tempblock.classList.add("selectedblock");
          }


          // if (this.tempblock && this.tempblock.closest(".block")) {
          //   this.tempblock.classList.remove("selectedblock");
          // }
          // this.tempblock = event.target.closest(".block");
          // this.tempblock = event.target.closest(".block").classList.add("selectedblock");
        }
      }
    },
    savedata() {
      if (this.tempblock) {
        var type = this.tempblock.querySelector(".blockelemtype").value;
        switch (type) {
          case "email":
            this.tempblock.querySelector(".blockytitle").innerHTML = this.getKeepText(this.emailtemp.title);
            this.tempblock.querySelector(".blockycontent").innerHTML = this.getKeepText(this.emailtemp.content, 30);

            break;
          case "sms":
            this.tempblock.querySelector(".blockytitle").innerHTML = this.getKeepText(this.smstemp.title);
            this.tempblock.querySelector(".blockycontent").innerHTML = this.getKeepText(this.smstemp.content, 30);
            break;
          case "profile":
            this.tempblock.querySelector(".blocktitle").innerHTML = this.getKeepText(this.profiletemp.title);
            break;
          case "webhook":
            this.tempblock.querySelector(".blocktitle").innerHTML = this.getKeepText(this.webhook);
            break;
          case "time":

            this.tempblock.querySelector(".blocktitle").innerHTML = `Wait ${this.time}  hours`

            break;
        }
      }
    },
    removeblocks() {
      flowy.deleteBlocks()
    },
    getKeepText(text, len) {
      var leng = len ? len : 20;
      if (typeof text === 'string')
        return text.length > leng ? text.substring(0, leng) + "..." : text;
      else {
        return ''
      }
    }
  }
}
</script>

<style>
.home-container {
  position: absolute;
  /* margin: 0px;
  padding: 0px; */
  /* left: 10px; */
  margin-left: 10px;
  width: calc(100% - 321px);
  height: calc(100% - 120px);
  overflow: hidden;
}

.side-bar {
  /* height: 600px; */
  display: flex;
  top: 10px;
  left: 10px;
  flex-direction: column;
  position: absolute;
  z-index: 10;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 20px
}

.propwrap {
  height: 600px;
  display: flex;
  flex-direction: column;
  padding: 10px;
  left: -300px;
  position: absolute;
  z-index: 10;
  opacity: 0;
  top: 10px;
  background-color: rgba(20, 20, 20, 0.5);
  transition: all .3s cubic-bezier(.05, .03, .35, 1);
}

.expanded {
  left: 10px !important;
  opacity: 1 !important;
  box-shadow: -4px 0px 40px rgba(26, 26, 73, 0.05);

}

.side-bar>h2 {
  color: #ffffff;
  margin-top: 10px;
}

.block-wrapper {}

.block-wrapper>.blockelem {
  margin-top: 5px;
}

.blockelem:first-child {
  margin-top: 10px
}

.blockelem {
  width: 300px;
  border: 1px solid transparent;
  transition-property: box-shadow, height;
  transition-duration: .2s;
  transition-timing-function: cubic-bezier(.05, .03, .35, 1);
  border-radius: 5px;
  box-shadow: 0px 0px 30px rgba(22, 33, 74, 0);
  box-sizing: border-box;
  background-color: #FFF;
  padding: 10px;
}

.blockelem:hover {
  box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.08);
  border-radius: 5px;
  background-color: #FFF;
  cursor: pointer;
}

.blockin {
  display: flex;
  flex-direction: row;
}

.blockico {
  width: 36px;
  height: 36px;
  background-color: #F1F4FC;
  border-radius: 5px;
  position: relative;
}

.blockico>img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.blockin>.blocktitle {
  line-height: 2;
  width: 80%;
  padding-left: 10px;
}



#flowy-canvas {
  position: absolute;
  width: calc(100%);
  height: calc(100%);
  top: 0;
  left: 0;
  z-index: 0;
  overflow: auto;
  overflow-x: hidden;
  background-image: url(./images/tile.png);
  background-repeat: repeat;
  background-size: 30px 30px;
  background-color: #ffffff23;
  scrollbar-color: #6969dd #e0e0e0;
  scrollbar-width: thin;
  /* background: red; */
}

.blockdisabled {
  background-color: #F0F2F9;
  opacity: .5;
}

.blockyWrapper {
  display: flex;
  flex-direction: row;

}

.blockycontainer {
  width: 80%;
}

.blockytitle {
  padding-top: 10px;
  padding-left: 15px;
  font-size: 13px;
  font-weight: 400;
}

.blockycontent {
  padding: 10px;
  font-size: 16px;
  font-weight: 500;
}

.blocky {
  display: flex;
  flex-direction: column;
}

.blocky-top {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.blocky-bottom {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.filter-btn {
  border: .2px solid rgba(83, 83, 83, 0.308);
  padding: 2px;
  border-radius: 2px;
}

.action-btns {
  display: flex;
  flex-direction: row;
  /* height: 20px; */
  /* border: .5px solid rgba(34, 34, 34, 0.308); */
  /* padding: 2px; */
  /* border-radius: 2px; */
}

.action-btns>img {
  border: .2px solid rgba(83, 83, 83, 0.308);
  padding: 2px;
  border-radius: 2px;
  margin-left: 2px;
}


.noselect {
  -webkit-touch-callout: none;
  /* iOS Safari */
  -webkit-user-select: none;
  /* Safari */
  -khtml-user-select: none;
  /* Konqueror HTML */
  -moz-user-select: none;
  /* Old versions of Firefox */
  -ms-user-select: none;
  /* Internet Explorer/Edge */
  user-select: none;
  /* Non-prefixed version, currently
                                  supported by Chrome, Opera and Firefox */
}

.m-btn {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid;
  padding-left: 20px;
  padding-right: 20px;
}

.selectedblock {
  border: 2px solid #217CE8;
  box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.08);
}

.edit-close-btn {
  cursor: pointer;
}

.properties {
  display: flex;
  flex-direction: column;
}

.properties>div {
  padding-top: 50px;
  padding-bottom: 10px;
  color: white;
}

.m-btn-group {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}

.dropme {
  background-color: #FFF;
  border-radius: 5px;
  border: 1px solid #E8E8EF;
  box-shadow: 0px 2px 8px rgba(34, 34, 87, 0.05);
  font-family: Roboto;
  font-size: 14px;
  color: #253134;
  text-indent: 20px;
  height: 40px;
  line-height: 40px;
  width: 287px;
  margin-bottom: 25px;
}

.dropme>option :root {
  --select-border: #777;
  --select-focus: blue;
  --select-arrow: var(--select-border);
}

.label {
  font-size: 18px;
  font-weight: 500;
  color: white;
}

::-webkit-scrollbar {
  width: 5px;
  height: 5px;
}

::-webkit-scrollbar-track {
  background-color: rgb(236, 216, 216);
}

::-webkit-scrollbar-thumb {
  box-shadow: inset 0 0 6px rgba(87, 42, 250, 0.712);
}
</style>
