// Inisialisasi canvas Fabric.js dengan background kaos
const canvas = new fabric.Canvas("tshirtCanvas", {
  preserveObjectStacking: true,
  selection: true,
});

// Cek apakah ada data tersimpan sebelumnya di localStorage
const savedDesign = localStorage.getItem("kaosDesign");
if (savedDesign) {
  canvas.loadFromJSON(savedDesign, () => {
    // Pulihkan properti name pada image jika tidak tersedia
    canvas.getObjects().forEach((o) => {
      if (o.type === "image") {
        o.name = o.name || "Gambar";
      }
    });
    canvas.renderAll();
    updateList();
  });
} else {
  canvas.setBackgroundImage(
    "image/product4.jpeg",
    canvas.renderAll.bind(canvas),
    {
      scaleX: 600 / 800,
      scaleY: 600 / 800,
    }
  );
}

// Inisialisasi font size options
const fontSizeSelect = document.getElementById("fontSize");
for (let i = 10; i <= 64; i += 2) {
  const option = document.createElement("option");
  option.value = i;
  option.textContent = `${i}px`;
  fontSizeSelect.appendChild(option);
}

let currentFont = "Arial";
let fontsList = [];
const apiKey = "AIzaSyBbHsIzkkLsTKLNRcomvRlw-qZqWeC91OU";

// Ambil daftar font dari Google Fonts
fetch(`https://www.googleapis.com/webfonts/v1/webfonts?key=${apiKey}`)
  .then((r) => r.json())
  .then((d) => {
    fontsList = d.items.map((i) => i.family);
    renderFonts(fontsList);
  });

function renderFonts(arr) {
  const container = document.getElementById("fontList");
  container.innerHTML = "";
  arr.forEach((f) => {
    const col = document.createElement("div");
    col.className = "col-md-4 mb-2";

    const btn = document.createElement("button");
    btn.className = "btn btn-outline-secondary w-100 font-preview";
    btn.textContent = f;
    btn.style.fontFamily = f;

    btn.onclick = () => {
      currentFont = f;
      loadFont(f);

      const txt = new fabric.Textbox("Teks Baru", {
        left: 100,
        top: 100,
        fontFamily: f,
        fontSize: parseInt(document.getElementById("fontSize").value),
        fill: document.getElementById("textColor").value,
        backgroundColor: document.getElementById("bgTransparent").checked
          ? ""
          : document.getElementById("textBgColor").value,
      });
      canvas.add(txt).setActiveObject(txt);
      updateList();
      bootstrap.Modal.getInstance(document.getElementById("fontModal")).hide();
    };

    col.appendChild(btn);
    container.appendChild(col);
  });
}

document.getElementById("fontSearch").oninput = (e) => {
  renderFonts(
    fontsList.filter((f) =>
      f.toLowerCase().includes(e.target.value.toLowerCase())
    )
  );
};

function loadFont(f) {
  const link = document.createElement("link");
  link.rel = "stylesheet";
  link.href = `https://fonts.googleapis.com/css2?family=${f.replace(
    / /g,
    "+"
  )}&display=swap`;
  document.head.appendChild(link);
}

function updateActiveText(prop, value) {
  const o = canvas.getActiveObject();
  if (o && o.type === "textbox") {
    o.set(prop, value);
    canvas.renderAll();
  }
}

document.getElementById("textColor").onchange = (e) => {
  updateActiveText("fill", e.target.value);
};

document.getElementById("textBgColor").onchange = (e) => {
  const val = document.getElementById("bgTransparent").checked
    ? ""
    : e.target.value;
  updateActiveText("backgroundColor", val);
};

document.getElementById("bgTransparent").onchange = () => {
  const val = document.getElementById("bgTransparent").checked
    ? ""
    : document.getElementById("textBgColor").value;
  updateActiveText("backgroundColor", val);
};

document.getElementById("fontSize").onchange = (e) => {
  updateActiveText("fontSize", parseInt(e.target.value));
};

const toggleBtns = [
  "boldBtn",
  "italicBtn",
  "alignLeft",
  "alignCenter",
  "alignRight",
];
toggleBtns.forEach((id) => {
  document.getElementById(id).addEventListener("click", () => {
    const btn = document.getElementById(id);
    const o = canvas.getActiveObject();
    if (!o || o.type !== "textbox") return;

    if (id === "boldBtn") {
      btn.classList.toggle("active");
      o.set("fontWeight", btn.classList.contains("active") ? "bold" : "normal");
    } else if (id === "italicBtn") {
      btn.classList.toggle("active");
      o.set(
        "fontStyle",
        btn.classList.contains("active") ? "italic" : "normal"
      );
    } else if (id.startsWith("align")) {
      ["alignLeft", "alignCenter", "alignRight"].forEach((a) =>
        document.getElementById(a).classList.remove("active")
      );
      btn.classList.add("active");
      o.set("textAlign", id.replace("align", "").toLowerCase());
    }

    canvas.renderAll();
  });
});

const imageInput = document.getElementById("imageUpload");
imageInput.onchange = (e) => {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (f) => {
    fabric.Image.fromURL(f.target.result, (img) => {
      img.scaleToWidth(60);
      img.set("name", file.name);

      img.toObject = ((toObject) => {
        return function () {
          return fabric.util.object.extend(toObject.call(this), {
            name: this.name || "",
          });
        };
      })(img.toObject);

      canvas.add(img);
      updateList();
    });
  };
  reader.readAsDataURL(file);
};

function updateList() {
  const ul = document.getElementById("designList");
  ul.innerHTML = "";

  canvas.getObjects().forEach((o) => {
    // Filter hanya objek yang valid
    const isValidTextbox =
      o.type === "textbox" &&
      o.text &&
      o.text.trim() !== "" &&
      o.text !== "Komponen";
    const isValidImage =
      o.type === "image" &&
      o.name &&
      o.name.trim() !== "" &&
      o.name.toLowerCase() !== "komponen";

    // Jika bukan textbox atau image yang valid, abaikan
    if (!isValidTextbox && !isValidImage) return;

    const li = document.createElement("li");
    li.className =
      "list-group-item d-flex justify-content-between align-items-center";

    const label = isValidTextbox ? `Teks: ${o.text}` : `Gambar: ${o.name}`;

    li.textContent = label;

    const btn = document.createElement("button");
    btn.className = "btn btn-sm btn-danger";
    btn.textContent = "Hapus";
    btn.onclick = () => {
      canvas.remove(o);
      updateList();
    };

    li.appendChild(btn);
    ul.appendChild(li);
  });
}

const clearBtn = document.getElementById("clearCanvas");
clearBtn.onclick = () => {
  canvas.clear();
  canvas.setBackgroundImage(
    "image/product4.jpeg",
    canvas.renderAll.bind(canvas),
    {
      scaleX: 600 / 800,
      scaleY: 600 / 800,
    }
  );
  updateList();
};

const lineX = document.getElementById("lineX");
const lineY = document.getElementById("lineY");
const rulerX = document.getElementById("rulerX");
const rulerY = document.getElementById("rulerY");

canvas.on("object:moving", (e) => {
  const { left, top } = e.target;
  lineX.style.top = `${top}px`;
  lineY.style.left = `${left}px`;

  rulerX.style.top = `${top - 15}px`;
  rulerX.style.left = `0px`;
  rulerX.innerText = `Y: ${Math.round(top)}`;

  rulerY.style.left = `${left + 5}px`;
  rulerY.style.top = `0px`;
  rulerY.innerText = `X: ${Math.round(left)}`;

  lineX.style.display =
    lineY.style.display =
    rulerX.style.display =
    rulerY.style.display =
      "block";
});

canvas.on("mouse:up", () => {
  lineX.style.display =
    lineY.style.display =
    rulerX.style.display =
    rulerY.style.display =
      "none";
});

const saveBtn = document.getElementById("saveDesign");
saveBtn.onclick = () => {
  const json = JSON.stringify(canvas.toJSON());
  localStorage.setItem("kaosDesign", json);
  window.location.href = "preview.html";
};
