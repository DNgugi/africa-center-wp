// mailchimp-embed.js
// Moved from inline embed script. Keeps Mailchimp validation and SMS helpers.
(function ($) {
  // Mailchimp field names/types
  window.fnames = window.fnames || [];
  window.ftypes = window.ftypes || [];
  fnames[0] = "EMAIL";
  ftypes[0] = "email";
  fnames[2] = "NAME";
  ftypes[2] = "text";
  fnames[3] = "MMERGE3";
  ftypes[3] = "text";
  fnames[1] = "MMERGE1";
  ftypes[1] = "text";
  fnames[4] = "MMERGE4";
  ftypes[4] = "text";
  fnames[5] = "MMERGE5";
  ftypes[5] = "text";
  fnames[6] = "MMERGE6";
  ftypes[6] = "text";
  fnames[7] = "MMERGE7";
  ftypes[7] = "text";
  fnames[8] = "MMERGE8";
  ftypes[8] = "text";
})(jQuery);

var $mcj = jQuery.noConflict(true);

// Minimal SMS phone defaults (keeps behavior from original embed)
if (!window.MC) window.MC = {};
window.MC.smsPhoneData = window.MC.smsPhoneData || {};
window.MC.smsPhoneData.defaultCountryCode =
  window.MC.smsPhoneData.defaultCountryCode || "HK";
window.MC.smsPhoneData.programs = window.MC.smsPhoneData.programs || [];
window.MC.smsPhoneData.smsProgramDataCountryNames =
  window.MC.smsPhoneData.smsProgramDataCountryNames || [];

// Small utilities used by the original script (sanitizers and helpers)
function getCountryUnicodeFlag(countryCode) {
  if (!countryCode) return "";
  return countryCode.toUpperCase().replace(/./g, function (char) {
    return String.fromCodePoint(char.charCodeAt(0) + 127397);
  });
}

function sanitizeHtml(str) {
  if (typeof str !== "string") return "";
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#x27;")
    .replace(/\//g, "&#x2F;");
}

function sanitizeUrl(url) {
  if (typeof url !== "string") return "";
  var trimmed = url.trim().toLowerCase();
  if (
    trimmed.startsWith("javascript:") ||
    trimmed.startsWith("data:") ||
    trimmed.startsWith("vbscript:")
  ) {
    return "#";
  }
  return url;
}

// Basic helpers for country/program handling used in original script
function getBrowserLanguage() {
  try {
    if (!window.navigator || !window.navigator.language) return null;
    var parts = window.navigator.language.split("-");
    return parts.length > 1
      ? parts[1].toUpperCase()
      : window.navigator.language.toUpperCase();
  } catch (e) {
    return null;
  }
}

function getDefaultCountryProgram(defaultCountryCode, smsProgramData) {
  if (!smsProgramData || smsProgramData.length === 0) return null;
  var browserLang = getBrowserLanguage();
  if (browserLang) {
    for (var i = 0; i < smsProgramData.length; i++) {
      if (smsProgramData[i] && smsProgramData[i].countryCode === browserLang)
        return smsProgramData[i];
    }
  }
  if (defaultCountryCode) {
    for (var j = 0; j < smsProgramData.length; j++) {
      if (
        smsProgramData[j] &&
        smsProgramData[j].countryCode === defaultCountryCode
      )
        return smsProgramData[j];
    }
  }
  return smsProgramData[0];
}

// The rest of the original script had many features for SMS fields; for the widget we initialize any dropdowns and defaults
function initializeSmsPhoneDropdowns() {
  var smsPhoneFields = document.querySelectorAll('[id^="country-select-"]');
  smsPhoneFields.forEach(function (dropdown) {
    var fieldName = dropdown.id.replace("country-select-", "");
    var smsPhoneData = window.MC && window.MC.smsPhoneData;
    if (!smsPhoneData) return;
    if (smsPhoneData.programs && Array.isArray(smsPhoneData.programs)) {
      dropdown.innerHTML = smsPhoneData.programs
        .map(function (p) {
          var safe =
            '<option value="' +
            sanitizeHtml(p.countryCode || "") +
            '">' +
            sanitizeHtml(p.countryName || p.countryCode) +
            "</option>";
          return safe;
        })
        .join("");
    }
    var defaultProg = getDefaultCountryProgram(
      smsPhoneData.defaultCountryCode,
      smsPhoneData.programs
    );
    if (defaultProg) dropdown.value = defaultProg.countryCode;
  });
}

document.addEventListener("DOMContentLoaded", function () {
  try {
    initializeSmsPhoneDropdowns();
  } catch (e) {
    /* ignore */
  }
});
