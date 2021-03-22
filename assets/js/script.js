function togggleBoolAttr(el, attr) {
  return attr == "true" ? "false" : "true";
}

function togggleHiddenAttr(el, attr) {
  if (attr === true || attr === "hidden") return false;
  return true;
}


jQuery(document).ready(function ($) {
  /**
   * Simple front-end search of alumni by name
   * See `template-alumni-members.php` for reference
   **/
  function alumniSearch(term) {
    const $allAlumni = $('[data-alumni-name]')

    if (term === '') {
      $allAlumni.show()
    }

    const $alumniMatches = $('[data-alumni-name*="' + term.toLowerCase()  +'"]')
    if ($alumniMatches.length > 0) {
      $allAlumni.hide()
      $alumniMatches.show()
    }

    return $alumniMatches.length
  }

  // Toggle alumni form to add post
  const $alumniTopicFormButton = $('#forum-topic-form-button')
  const $alumniTopicForm = $('#forum-topic-form')

  $alumniTopicForm.hide()
  $alumniTopicFormButton.click(function (event) {
    event.preventDefault()
    $alumniTopicFormButton.hide()
    $alumniTopicForm.show()
  })


  // Homepage slider
  var sliderClass = ".testimonials-slider";
  if ($(sliderClass).length > 0) {
    new Glide(sliderClass, { autoplay: 5000 }).mount();
  }

  $("#alumni-member-search").on("keyup", function (event) {
    const result = alumniSearch(event.currentTarget.value)
    const errorMsg = $("#alumni-search-no-results")
    if (result === 0 && errorMsg.length > 0) {

    } else if (result === 0 && errorMsg.length === 0) {
      $(`<p id="alumni-search-no-results">No results for your search.</p>`).insertAfter($(this))
    } else {
      errorMsg.remove()
    }
  })

  // Accordions
  // accordionHeader.click(() => accordionBody where labelledby = accordionHeader.id remove hide)
  $(".accordion-header").click(function (event) {
    var $el = $(event.currentTarget);
    var bodyId = $el.attr("aria-controls");
    var $accBody = $('[id="' + bodyId + '"]');

    // flip aria expanded
    $el.attr("aria-expanded", togggleBoolAttr);
    $accBody.attr("hidden", togggleHiddenAttr);
  });

  // FAQ Page
  if ($(".page-template-template-faq").length > 0) {
    var lock = false;
    var $faqLinks = $('[href^="#"]');

    // Set the active link from the url hash
    function setActiveFromHash() {
      var $activeFAQLink = $('.faq-sidebar a[href="' + window.location.hash + '"]');

      if ($activeFAQLink.length > 0) {
        $faqLinks.removeClass("active");
        $activeFAQLink.addClass("active");
      }
    }

    setActiveFromHash();

    // When the hash is updated, add the active class to the sidebar items
    $(window).on("hashchange", function (event) {
      event.preventDefault();
      setActiveFromHash();
    });

    TableOfContents.init();
  }
});

/**
 * Object to set the links active when headings are scrolled by.
 * @todo: Move to own file.
 */
var TableOfContents = {
  container: document.body,
  links: null,
  headings: null,
  intersectionOptions: {
    rootMargin: "0px",
    threshold: 1,
  },
  previousSection: null,
  observer: null,
  activeClass: "active",

  init: function () {
    this.handleObserver = this.handleObserver.bind(this);

    this.setUpObserver();
    this.findLinksAndHeadings();
    this.observeSections();
  },

  handleLinkClick: function (evt) {
    evt.preventDefault();
    let id = evt.target.getAttribute("href").replace("#", "");

    let section = this.headings.find((heading) => {
      return heading.getAttribute("id") === id;
    });

    section.setAttribute("tabindex", -1);
    section.focus();

    window.scroll({
      behavior: "smooth",
      top: section.offsetTop - 15,
      block: "start",
    });

    if (this.container.classList.contains(this.activeClass)) {
      this.container.classList.remove(this.activeClass);
    }
  },

  handleObserver: function (entries, observer) {
    entries.forEach((entry) => {
      let href = `#${entry.target.getAttribute("id")}`,
        link = this.links.find((l) => l.getAttribute("href") === href);

      if (entry.isIntersecting && entry.intersectionRatio >= 1) {
        link.classList.add("is-visible");
        this.previousSection = entry.target.getAttribute("id");
      } else {
        link.classList.remove("is-visible");
      }

      this.highlightFirstActive();
    });
  },

  highlightFirstActive: function () {
    let firstVisibleLink = this.container.querySelector(".is-visible");

    this.links.forEach((link) => {
      link.classList.remove(this.activeClass);
    });

    if (firstVisibleLink) {
      firstVisibleLink.classList.add(this.activeClass);
    }

    if (!firstVisibleLink && this.previousSection) {
      this.container
        .querySelector(`a[href="#${this.previousSection}"]`)
        .classList.add(this.activeClass);
    }
  },

  observeSections: function () {
    this.headings.forEach((heading) => {
      this.observer.observe(heading);
    });
  },

  setUpObserver: function () {
    this.observer = new IntersectionObserver(this.handleObserver, this.intersectionOptions);
  },

  findLinksAndHeadings: function () {
    this.links = [...this.container.querySelectorAll(".faq-sidebar a")];
    this.headings = this.links.map((link) => {
      let id = link.getAttribute("href");
      return document.querySelector(id);
    });
  },
};
