function GameStart() {}

function GameEnd() {
  document.querySelector("#GameRequired").classList.remove("--inactive");
}

function GameParcoursNext() {
  setTimeout(() => {
    document.querySelector("#GameRequired").classList.add("--inactive");
    window.location.replace("./src/levels/lvlIW.php?reqmode=end");
  }, 3000);
}

function GameEndScroll() {} //depreciated
