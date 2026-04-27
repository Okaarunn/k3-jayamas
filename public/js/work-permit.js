(function () {
  "use strict";

  const TABS = ["tab-vendor", "tab-checklist", "tab-jsa", "tab-lembur"];
  const TAB_LINKS = [
    "tab-vendor-link",
    "tab-checklist-link",
    "tab-jsa-link",
    "tab-lembur-link",
  ];
  const DAYS_ID = [
    "Minggu",
    "Senin",
    "Selasa",
    "Rabu",
    "Kamis",
    "Jumat",
    "Sabtu",
  ];

  let currentTab = 0; // active tab index (0-based)
  let adaLembur = false; // toggle state
  let tahapCount = 0; // JSA tahap counter

  // ── Init ──────────────────────────────────
  function init() {
    addTahapPekerjaan(); // first tahap
    bindEvents();
    renderNavButtons();
    updateProgressBar();
  }

  // ── Tab switching ─────────────────────────
  function switchTab(index, skipValidation) {
    if (index === 3 && !adaLembur) return; // lembur locked
    if (index > currentTab && !skipValidation) {
      if (!validateTab(currentTab)) return;
    }

    // Deactivate current
    var curPane = document.getElementById(TABS[currentTab]);
    if (curPane) {
      curPane.classList.remove("active", "show");
    }
    var curLink = document.getElementById(TAB_LINKS[currentTab]);
    if (curLink) {
      curLink.classList.remove("active");
    }

    // Mark previous as done
    if (index > currentTab) {
      var doneLink = document.getElementById(TAB_LINKS[currentTab]);
      if (doneLink) doneLink.classList.add("done");
    }

    currentTab = index;

    // Activate new
    var newPane = document.getElementById(TABS[currentTab]);
    if (newPane) {
      newPane.classList.add("active", "show");
    }
    var newLink = document.getElementById(TAB_LINKS[currentTab]);
    if (newLink) {
      newLink.classList.remove("tab-locked");
      newLink.classList.add("active");
    }

    hideBanner();
    renderNavButtons();
    updateProgressBar();
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  }

  // ── Validation ────────────────────────────
  function validateTab(index) {
    var pane = document.getElementById(TABS[index]);
    if (!pane) return true;

    var inputs = pane.querySelectorAll(
      "input[required], select[required], textarea[required]",
    );
    var valid = true;

    inputs.forEach(function (el) {
      // Skip hidden elements
      if (el.offsetParent === null) return;

      var val = el.value.trim();
      if (!val) {
        el.classList.add("is-invalid");
        valid = false;
      } else {
        el.classList.remove("is-invalid");
        el.classList.add("is-valid");
      }
    });

    // Radio groups validation
    var radioGroups = {};
    var radios = pane.querySelectorAll('input[type="radio"][required]');
    radios.forEach(function (r) {
      if (r.offsetParent === null) return;
      radioGroups[r.name] = radioGroups[r.name] || [];
      radioGroups[r.name].push(r);
    });
    Object.keys(radioGroups).forEach(function (name) {
      var group = radioGroups[name];
      var checked = group.some(function (r) {
        return r.checked;
      });
      if (!checked) {
        group.forEach(function (r) {
          r.classList.add("is-invalid");
        });
        valid = false;
      } else {
        group.forEach(function (r) {
          r.classList.remove("is-invalid");
        });
      }
    });

    if (!valid) {
      showBanner(
        "Mohon lengkapi semua field yang wajib diisi sebelum melanjutkan.",
      );
    }
    return valid;
  }

  function showBanner(msg) {
    var b = document.getElementById("validationBanner");
    document.getElementById("validationMsg").textContent = msg;
    b.classList.add("show");
  }

  function hideBanner() {
    document.getElementById("validationBanner").classList.remove("show");
  }

  // ── Render nav buttons ────────────────────
  function renderNavButtons() {
    const step = document.getElementById("stepIndicator");
    const prevBtn = document.getElementById("btnPrev");
    const nextArea = document.getElementById("btnNextArea");

    if (!nextArea) return;

    const effectiveTotal = adaLembur ? 4 : 3;
    const isFirst = currentTab === 0;
    const isLast = currentTab === effectiveTotal - 1;

    if (step) {
      step.textContent = `Langkah ${currentTab + 1} dari ${effectiveTotal}`;
    }

    if (prevBtn) {
      prevBtn.style.display = isFirst ? "none" : "inline-flex";
    }

    let buttonHTML = "";

    if (isLast) {
      buttonHTML = `
            <button type="submit" form="workPermitForm" class="btn-nav btn-nav-submit">
                <i class="fas fa-paper-plane"></i>
                Submit Work Permit
            </button>
        `;
    } else if (currentTab === 2 && adaLembur) {
      buttonHTML = `
            <button type="button" class="btn-nav btn-nav-next" id="btnNext">
                <i class="fas fa-moon"></i>
                Continue ke Lembur
            </button>
        `;
    } else {
      buttonHTML = `
            <button type="button" class="btn-nav btn-nav-next" id="btnNext">
                Selanjutnya
                <i class="fas fa-arrow-right"></i>
            </button>
        `;
    }

    nextArea.innerHTML = buttonHTML;

    const nextBtn = document.getElementById("btnNext");
    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        if (validateTab(currentTab)) {
          switchTab(currentTab + 1, true);
        }
      });
    }
  }

  // ── Progress bar ──────────────────────────
  function updateProgressBar() {
    var total = adaLembur ? 4 : 3;
    var pct = ((currentTab + 1) / total) * 100;
    var bar = document.getElementById("progressBar");
    if (bar) bar.style.width = pct + "%";
  }

  // ── Lembur toggle ─────────────────────────
  function handleLemburToggle(checked) {
    adaLembur = checked;

    var tabLink = document.getElementById("tab-lembur-link");
    if (checked) {
      tabLink.classList.remove("tab-locked");
      tabLink.style.opacity = "";
    } else {
      tabLink.classList.add("tab-locked");
      tabLink.style.opacity = "";
      // If currently on lembur tab, go back to JSA
      if (currentTab === 3) switchTab(2, true);
    }

    var infoBox = document.getElementById("lemburInfoBox");
    if (infoBox) infoBox.classList.toggle("show", checked);

    renderNavButtons();
    updateProgressBar();
  }

  // ── JSA Tahap dynamic ─────────────────────
  function addTahapPekerjaan() {
    tahapCount++;
    var idx = tahapCount;
    var container = document.getElementById("tahapPekerjaanContainer");
    if (!container) return;

    var div = document.createElement("div");
    div.className = "tahap-card";
    div.id = "tahap-" + idx;
    div.innerHTML =
      '<div class="tahap-header">' +
      '<span class="tahap-label">Tahap ' +
      idx +
      "</span>" +
      (idx > 1
        ? '<button type="button" class="btn-remove-tahap" onclick="WP.removeTahap(' +
          idx +
          ')">' +
          '<i class="fas fa-trash"></i> Hapus' +
          "</button>"
        : "") +
      "</div>" +
      '<div class="row">' +
      '<div class="col-12 mb-3">' +
      '<label class="form-label-k3">Tahapan Pekerjaan</label>' +
      '<textarea name="tahap_pekerjaan[]" class="form-control-k3" required></textarea>' +
      "</div>" +
      '<div class="col-md-6 mb-3">' +
      "<label>Potensi Bahaya</label>" +
      '<textarea name="bahaya_pekerjaan[]" class="form-control-k3" required></textarea>' +
      "</div>" +
      '<div class="col-md-6 mb-3">' +
      "<label>Risiko</label>" +
      '<textarea name="resiko_pekerjaan[]" class="form-control-k3" required></textarea>' +
      "</div>" +
      '<div class="col-md-6 mb-3">' +
      "<label>Pengendalian</label>" +
      '<textarea name="pengendalian[]" class="form-control-k3" required></textarea>' +
      "</div>" +
      '<div class="col-md-6 mb-3">' +
      "<label>Penanggung Jawab</label>" +
      '<input type="text" name="penanggung_jawab[]" class="form-control-k3" required>' +
      "</div>" +
      "</div>";

    container.appendChild(div);
  }

  function removeTahap(idx) {
    var el = document.getElementById("tahap-" + idx);
    if (el) el.remove();
  }

  // ── Auto-fill hari dari tanggal lembur ────
  function handleTanggalLembur(val) {
    var hariInput = document.getElementById("hariLembur");
    if (!hariInput || !val) return;
    var d = new Date(val);
    hariInput.value = DAYS_ID[d.getDay()];
  }

  // ── Auto hitung durasi lembur ─────────────
  function calculateDurasi() {
    var mulai = document.querySelector('input[name="jam_mulai_lembur"]');
    var selesai = document.querySelector('input[name="jam_selesai_lembur"]');
    var durasi = document.querySelector('input[name="durasi_lembur"]');
    if (!mulai || !selesai || !durasi || !mulai.value || !selesai.value) return;

    var [jm, mm] = mulai.value.split(":").map(Number);
    var [js, ms] = selesai.value.split(":").map(Number);
    var diff = js * 60 + ms - (jm * 60 + mm);
    if (diff < 0) diff += 24 * 60;
    durasi.value = Math.round((diff / 60) * 2) / 2 || "";
  }

  // ── Bind events ───────────────────────────
  function bindEvents() {
    // Toggle vendor fields berdasarkan tipe pengaju
    function toggleVendorFields(tipe) {
      var isVendor = tipe === "vendor";

      // Vendor fields: show jika vendor, hide jika internal
      document.getElementById("wrap_alamat_vendor").style.display = isVendor
        ? ""
        : "none";
      document.getElementById("wrap_notelp_vendor").style.display = isVendor
        ? ""
        : "none";
      document.getElementById("wrap_nama_pekerja_vendor").style.display =
        isVendor ? "" : "none";
      document.getElementById("wrap_jabatan_pekerja_vendor").style.display =
        isVendor ? "" : "none";
      document.getElementById("wrap_no_ktp_pic_vendor").style.display = isVendor
        ? ""
        : "none";

      document.getElementById("alamat_vendor").disabled = !isVendor;
      document.getElementById("notelp_vendor").disabled = !isVendor;
      document.getElementById("nama_pekerja_vendor").disabled = !isVendor;
      document.getElementById("jabatan_pekerja_vendor").disabled = !isVendor;
      document.getElementById("no_ktp_pic_vendor").disabled = !isVendor;

      // Departemen: show jika vendor, hide jika internal
      document.getElementById("wrap_departemen").style.display = isVendor
        ? ""
        : "none";
      document.getElementById("departemen").disabled = !isVendor;

      if (!isVendor) {
        document.getElementById("alamat_vendor").value = "";
        document.getElementById("notelp_vendor").value = "";
        document.getElementById("departemen").value = "";
      }
    }

    var tipePengaju = document.getElementById("tipe_pengaju");
    if (tipePengaju) {
      tipePengaju.addEventListener("change", function () {
        toggleVendorFields(this.value);
      });
      // Jalankan saat init jika sudah ada nilai
      if (tipePengaju.value) toggleVendorFields(tipePengaju.value);
    }

    // Sync departemen = nama_pengaju jika internal
    document
      .getElementById("nama_pengaju")
      .addEventListener("input", function () {
        if (document.getElementById("tipe_pengaju").value === "internal") {
          document.getElementById("departemen").value = this.value;
        }
      });
    // Tab header clicks
    document
      .querySelectorAll(".nav-tabs-k3 .nav-link")
      .forEach(function (link) {
        link.addEventListener("click", function () {
          if (this.classList.contains("tab-locked")) return;
          var idx = parseInt(this.getAttribute("data-tab-index"));
          if (idx === 3 && !adaLembur) return;
          if (idx <= currentTab) {
            switchTab(idx, true); // going back — no validation
          } else {
            switchTab(idx);
          }
        });
      });
    document
      .querySelectorAll(
        "#workPermitForm input, #workPermitForm select, #workPermitForm textarea",
      )
      .forEach(function (el) {
        el.addEventListener("change", function () {
          if (this.hasAttribute("required")) {
            if (this.value.trim()) {
              this.classList.remove("is-invalid");
              this.classList.add("is-valid");
            }
          }
        });
      });

    // Prev button
    var prevBtn = document.getElementById("btnPrev");
    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        if (currentTab > 0) switchTab(currentTab - 1, true);
      });
    }

    // Add tahap button
    var addBtn = document.getElementById("addTahapBtn");
    if (addBtn) addBtn.addEventListener("click", addTahapPekerjaan);

    // Lembur toggle switch
    var lemburSwitch = document.getElementById("lemburToggle");
    if (lemburSwitch) {
      lemburSwitch.addEventListener("change", function () {
        handleLemburToggle(this.checked);
      });
    }

    // Tanggal lembur → auto hari
    var tanggalLembur = document.querySelector('input[name="tanggal_lembur"]');
    if (tanggalLembur) {
      tanggalLembur.addEventListener("change", function () {
        handleTanggalLembur(this.value);
      });
    }

    // Durasi lembur auto-calc
    var jamMulai = document.querySelector('input[name="jam_mulai_lembur"]');
    var jamSelesai = document.querySelector('input[name="jam_selesai_lembur"]');
    if (jamMulai) jamMulai.addEventListener("change", calculateDurasi);
    if (jamSelesai) jamSelesai.addEventListener("change", calculateDurasi);

    // Clear invalid on input
    document
      .getElementById("workPermitForm")
      .addEventListener("input", function (e) {
        if (
          e.target.classList.contains("is-invalid") &&
          e.target.value.trim()
        ) {
          e.target.classList.remove("is-invalid");
          e.target.classList.add("is-valid");
        }
      });

    // Final form submit validation
    document
      .getElementById("workPermitForm")
      .addEventListener("submit", function (e) {
        var allValid = true;
        var tabs = adaLembur ? [0, 1, 2, 3] : [0, 1, 2];
        tabs.forEach(function (i) {
          if (!validateTabSilent(i)) allValid = false;
        });
        if (!allValid) {
          e.preventDefault();
          showBanner(
            "Masih ada field yang belum diisi. Periksa kembali setiap tab.",
          );
        }
      });
  }

  // Silent validate (no banner, just mark fields)
  function validateTabSilent(index) {
    var pane = document.getElementById(TABS[index]);
    if (!pane) return true;
    var inputs = pane.querySelectorAll(
      "input[required], select[required], textarea[required]",
    );
    var valid = true;
    inputs.forEach(function (el) {
      if (el.offsetParent === null) return;
      if (!el.value.trim()) {
        el.classList.add("is-invalid");
        valid = false;
      }
    });
    return valid;
  }

  // ── Public API ────────────────────────────
  window.WP = {
    addTahap: addTahapPekerjaan,
    removeTahap: removeTahap,
    handleLemburToggle: handleLemburToggle,
  };

  // ── Boot ─────────────────────────────────
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();

// alert
function showToast(message, type = "success") {
  const container = document.getElementById("toastContainer");

  const toast = document.createElement("div");
  toast.className = "k3-toast " + type;

  toast.innerHTML = `
        <div class="accent"></div>
        <div class="body">
            <div class="icon">
                <i class="fas ${type === "success" ? "fa-check" : "fa-times"}"></i>
            </div>
            <div class="text">
                <div class="title">${type === "success" ? "Berhasil" : "Error"}</div>
                <div class="msg">${message}</div>
            </div>
        </div>
    `;

  container.appendChild(toast);

  setTimeout(() => {
    toast.classList.add("show");
  }, 100);

  setTimeout(() => {
    toast.classList.add("hide");
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

document.addEventListener("DOMContentLoaded", function () {
  const flashSuccess = document.getElementById("flashSuccess");
  const flashError = document.getElementById("flashError");

  if (flashSuccess) {
    const msg = flashSuccess.getAttribute("data-msg");
    showToast(msg, "success");
  }

  if (flashError) {
    const msg = flashError.getAttribute("data-msg");
    showToast(msg, "error");
  }
});
