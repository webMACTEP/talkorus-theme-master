jQuery(document).ready(function ($) {
  function talkorusScrollToAccordionItem($item) {
    const $target = $item.find(".about-info__head").first();

    if (!$target.length) {
      return;
    }

    const header = document.querySelector("header");
    const headerHeight = header ? header.offsetHeight : 0;

    const extraOffset = 16;

    const targetTop =
      $target[0].getBoundingClientRect().top +
      window.pageYOffset -
      headerHeight -
      extraOffset;

    window.scrollTo({
      top: Math.max(0, targetTop),
      behavior: "smooth",
    });
  }

  function talkorusShouldScrollAccordionOnMobile($item) {
    return (
      window.matchMedia("(max-width: 1743px)").matches &&
      $item.closest(".about-info__accordion").length
    );
  }

  $(".about-info__item.active .about-info__body").each(function () {
    $(this).css("max-height", this.scrollHeight + "px");
  });

  $(".about-info__head").on("click", function () {
    const $item = $(this).closest(".about-info__item");
    const $body = $item.find(".about-info__body").first();
    const isActive = $item.hasClass("active");

    if (isActive) {
      $body.css("max-height", 0);
      $item.removeClass("active");
      return;
    }

    $(".about-info__item.active")
      .not($item)
      .each(function () {
        $(this).removeClass("active");
        $(this).find(".about-info__body").css("max-height", 0);
      });

    $item.addClass("active");
    $body.css("max-height", $body[0].scrollHeight + "px");

    if (talkorusShouldScrollAccordionOnMobile($item)) {
      setTimeout(function () {
        talkorusScrollToAccordionItem($item);
      }, 320);
    }
  });

  $(".hotspot__dot").on("click", function (e) {
    e.stopPropagation();

    const $hotspot = $(this).closest(".hotspot");
    const isActive = $hotspot.hasClass("active");

    $(".hotspot").removeClass("active");

    if (!isActive) {
      $hotspot.addClass("active");
    }
  });

  $(document).on("click", function () {
    $(".hotspot").removeClass("active");
  });

  const $burger = $(".burger");
  const $burgerMenu = $(".burger-menu");
  const $body = $("body");
  const $callbackModal = $(".callback-modal");

  $burger.on("click", function (e) {
    e.stopPropagation();

    $burger.toggleClass("active");
    $burgerMenu.toggleClass("active");
    $body.toggleClass("hold");
  });

  $burgerMenu.on("click", function (e) {
    e.stopPropagation();
  });

  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(".burger, .burger-menu").length &&
      $burgerMenu.hasClass("active")
    ) {
      $burger.removeClass("active");
      $burgerMenu.removeClass("active");
      $body.removeClass("hold");
    }
  });

  function talkorusOpenCallbackModal() {
    if (!$callbackModal.length) {
      return;
    }

    $burger.removeClass("active");
    $burgerMenu.removeClass("active");
    $body.removeClass("hold");

    $callbackModal.addClass("active").attr("aria-hidden", "false");
    $body.addClass("callback-modal-open");

    setTimeout(function () {
      const $firstField = $callbackModal
        .find(".talkorus-cf7-form__input")
        .filter(":visible")
        .first();

      ($firstField.length ? $firstField : $callbackModal.find(".callback-modal__close"))
        .first()
        .trigger("focus");
    }, 100);
  }

  function talkorusCloseCallbackModal() {
    if (!$callbackModal.length) {
      return;
    }

    $callbackModal.removeClass("active").attr("aria-hidden", "true");
    $body.removeClass("callback-modal-open");
  }

  $(".call-back").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    talkorusOpenCallbackModal();
  });

  $(".callback-modal [data-callback-modal-close]").on("click", function (e) {
    e.preventDefault();
    talkorusCloseCallbackModal();
  });

  $callbackModal.on("click", ".callback-modal__content", function (e) {
    e.stopPropagation();
  });

  function talkorusPrepareVariationImageLabels($scope) {
    const $root = $scope && $scope.length ? $scope : $(document);

    $root
      .find(".single-product-custom table.variations .image-variable-item")
      .each(function () {
        const $item = $(this);
        const label =
          $item.attr("data-title") ||
          $item.attr("title") ||
          $item.attr("aria-label") ||
          $item.find("img").attr("alt") ||
          $item.attr("data-value") ||
          $.trim($item.text());

        if (label) {
          const cleanLabel = $.trim(label);
          let $label = $item.children(".talkorus-variation-label");

          if (!$label.length) {
            $label = $("<span />", {
              class: "talkorus-variation-label",
            }).appendTo($item);
          }

          $item.attr("data-variation-label", cleanLabel);
          $label.text(cleanLabel);
        }
      });
  }

  talkorusPrepareVariationImageLabels();

  $(document).on(
    "wc_variation_form woo_variation_swatches_loaded woocommerce_variation_has_changed",
    function (event) {
      talkorusPrepareVariationImageLabels($(event.target));
    }
  );

  setTimeout(function () {
    talkorusPrepareVariationImageLabels();
  }, 500);

  function talkorusCloseMenuDropdowns($scope) {
    const $items = $scope
      ? $scope
          .filter(".main-menu__item--has-dropdown.is-open")
          .add($scope.find(".main-menu__item--has-dropdown.is-open"))
      : $(".main-menu__item--has-dropdown.is-open");

    $items
      .removeClass("is-open")
      .children(".main-menu__toggle")
      .attr("aria-expanded", "false");
  }

  $(".main-menu__toggle").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();

    const $button = $(this);
    const $item = $button.closest(".main-menu__item--has-dropdown");
    const isOpen = $item.hasClass("is-open");

    talkorusCloseMenuDropdowns(
      $item.siblings(".main-menu__item--has-dropdown.is-open")
    );

    if (isOpen) {
      talkorusCloseMenuDropdowns($item);
    } else {
      $item.addClass("is-open");
      $button.attr("aria-expanded", "true");
    }
  });

  $(".main-menu__dropdown").on("click", function (e) {
    e.stopPropagation();
  });

  $(document).on("click", function (e) {
    if (!$(e.target).closest(".main-menu__item--has-dropdown").length) {
      talkorusCloseMenuDropdowns();
    }
  });

  $(document).on("keydown", function (e) {
    if (e.key === "Escape") {
      talkorusCloseMenuDropdowns();
      talkorusCloseCallbackModal();
    }
  });

  if ($(".heroSwiper").length) {
    new Swiper(".heroSwiper", {
      loop: true,
      speed: 800,
      autoplay: {
        delay: 5000,
        disableOnInteraction: true,
        pauseOnMouseEnter: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
  }

  $(".project-card").each(function () {
    const slider = $(this).find(".project-card__slider")[0];
    const nextBtn = $(this).find(".project-card__nav--next")[0];
    const prevBtn = $(this).find(".project-card__nav--prev")[0];

    if (slider) {
      new Swiper(slider, {
        loop: true,
        speed: 600,
        autoHeight: true,
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
          nextEl: nextBtn,
          prevEl: prevBtn,
        },
      });
    }
  });

  $(".brand-certificates__slider").each(function () {
    const pagination = $(this).find(".brand-certificates__pagination")[0];
    const nextBtn = $(this).find(".brand-certificates__nav--next")[0];
    const prevBtn = $(this).find(".brand-certificates__nav--prev")[0];

    new Swiper(this, {
      loop: false,
      speed: 600,
      watchOverflow: true,
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: {
        el: pagination,
        clickable: true,
      },
      navigation: {
        nextEl: nextBtn,
        prevEl: prevBtn,
      },
      breakpoints: {
        744: {
          slidesPerView: 3,
          spaceBetween: 24,
        },
        1440: {
          slidesPerView: 2,
          spaceBetween: 24,
        },
      },
    });
  });

  $(".onego-reasons__slider").each(function () {
    const pagination = $(this).find(".onego-reasons__pagination")[0];

    new Swiper(this, {
      loop: false,
      speed: 600,
      watchOverflow: true,
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: {
        el: pagination,
        clickable: true,
      },
      breakpoints: {
        744: {
          slidesPerView: 2,
          spaceBetween: 18,
        },
        1440: {
          slidesPerView: 4,
          spaceBetween: 18,
        },
      },
    });
  });

  $(".onego-model__slider").each(function () {
    const pagination = $(this).find(".onego-model__pagination")[0];

    new Swiper(this, {
      loop: false,
      speed: 600,
      watchOverflow: true,
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: {
        el: pagination,
        clickable: true,
      },
      breakpoints: {
        744: {
          slidesPerView: 2,
          spaceBetween: 18,
        },
      },
    });
  });

  $(".onego-textures__slider").each(function () {
    const pagination = $(this).find(".onego-textures__pagination")[0];

    new Swiper(this, {
      loop: false,
      speed: 600,
      watchOverflow: true,
      slidesPerView: 1,
      spaceBetween: 16,
      pagination: {
        el: pagination,
        clickable: true,
      },
      breakpoints: {
        744: {
          slidesPerView: 2,
          spaceBetween: 18,
        },
        1440: {
          slidesPerView: 4,
          spaceBetween: 18,
        },
      },
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".catalog-card").forEach(function (card) {
    talkorusUpdateCatalogCardPrice(card);
  });
});

(function () {
  function talkorusInitCatalogCards(root) {
    const scope = root || document;

    scope.querySelectorAll(".catalog-card").forEach(function (card) {
      talkorusUpdateCatalogCardPrice(card);
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    talkorusInitCatalogCards(document);
  });

  document.addEventListener("click", function (event) {
    const variationItem = event.target.closest(".catalog-card .variable-item");

    if (!variationItem) {
      return;
    }

    const card = variationItem.closest(".catalog-card");

    if (!card) {
      return;
    }

    setTimeout(function () {
      talkorusUpdateCatalogCardPrice(card);
    }, 150);
  });

  document.addEventListener("change", function (event) {
    const select = event.target.closest(
      ".catalog-card .woo-variation-raw-select",
    );

    if (!select) {
      return;
    }

    const card = select.closest(".catalog-card");

    if (!card) {
      return;
    }

    talkorusUpdateCatalogCardPrice(card);
  });

  function talkorusUpdateCatalogCardPrice(card) {
    const cardInner = card.querySelector(".catalog-card__inner");
    const priceBox = card.querySelector(".catalog-card__price");

    if (!cardInner || !priceBox) {
      return;
    }

    const variationsRaw = cardInner.getAttribute("data-variation-prices");

    if (!variationsRaw) {
      return;
    }

    let variations = [];

    try {
      variations = JSON.parse(variationsRaw);
    } catch (error) {
      console.warn("Variation prices JSON error:", error);
      return;
    }

    if (!Array.isArray(variations) || !variations.length) {
      return;
    }

    const selectedAttributes = {};

    card
      .querySelectorAll(".woo-variation-raw-select")
      .forEach(function (select) {
        const attributeName = select.getAttribute("data-attribute_name");
        const value = select.value;

        if (attributeName && value) {
          selectedAttributes[attributeName] = value;
        }
      });

    const requiredAttributeNames = Object.keys(selectedAttributes);

    if (!requiredAttributeNames.length) {
      priceBox.innerHTML =
        cardInner.getAttribute("data-default-price") || priceBox.innerHTML;
      return;
    }

    const matchedVariation = variations.find(function (variation) {
      if (!variation.attributes) {
        return false;
      }

      return requiredAttributeNames.every(function (attributeName) {
        const selectedValue = selectedAttributes[attributeName];
        const variationValue = variation.attributes[attributeName];

        return variationValue === "" || variationValue === selectedValue;
      });
    });

    if (!matchedVariation || !matchedVariation.price_html) {
      priceBox.innerHTML =
        cardInner.getAttribute("data-default-price") || priceBox.innerHTML;
      return;
    }

    priceBox.innerHTML =
      '<span class="price-from">от</span> ' + matchedVariation.price_html;
  }

  /**
   * Важно для AJAX / подгрузки / catalog/page/2/
   * Следим за появлением новых карточек и инициализируем их.
   */
  const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      mutation.addedNodes.forEach(function (node) {
        if (!(node instanceof HTMLElement)) {
          return;
        }

        if (node.classList.contains("catalog-card")) {
          talkorusInitCatalogCards(node.parentElement || document);
          return;
        }

        if (node.querySelector && node.querySelector(".catalog-card")) {
          talkorusInitCatalogCards(node);
        }
      });
    });
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true,
  });

  /**
   * На случай если браузер вернул страницу из bfcache.
   */
  window.addEventListener("pageshow", function () {
    talkorusInitCatalogCards(document);
  });
})();

// прокрутка результатов фильтра

(function () {
  let talkorusFilterScrollPending = false;
  let talkorusFilterScrollTimer = null;

  function talkorusScrollToCatalogTop() {
    const target = document.querySelector(".catalog-content");

    if (!target) {
      return;
    }

    const header = document.querySelector("header");
    const headerHeight = header ? header.offsetHeight : 0;

    const top =
      target.getBoundingClientRect().top +
      window.pageYOffset -
      headerHeight -
      20;

    window.scrollTo({
      top: top,
      behavior: "smooth",
    });

    talkorusFilterScrollPending = false;
  }

  document.addEventListener("click", function (event) {
    const button = event.target.closest(".bapf_update");

    if (!button) {
      return;
    }

    talkorusFilterScrollPending = true;

    clearTimeout(talkorusFilterScrollTimer);

    // fallback, если AJAX-событие не поймали
    talkorusFilterScrollTimer = setTimeout(function () {
      if (talkorusFilterScrollPending) {
        talkorusScrollToCatalogTop();
      }
    }, 900);
  });

  const catalogContent = document.querySelector(".catalog-content");

  if (catalogContent) {
    const observer = new MutationObserver(function () {
      if (!talkorusFilterScrollPending) {
        return;
      }

      clearTimeout(talkorusFilterScrollTimer);

      talkorusFilterScrollTimer = setTimeout(function () {
        talkorusScrollToCatalogTop();
      }, 250);
    });

    observer.observe(catalogContent, {
      childList: true,
      subtree: true,
    });
  }
})();

document.addEventListener("DOMContentLoaded", function () {
  const filtersButton = document.querySelector(".filters");
  const catalogSidebar = document.querySelector(
    ".catalog-page .catalog-sidebar",
  );

  if (!filtersButton || !catalogSidebar) {
    return;
  }

  filtersButton.addEventListener("click", function () {
    catalogSidebar.classList.toggle("active");
  });
});

jQuery(function ($) {
  function escapeSelector(value) {
    if ($.escapeSelector) {
      return $.escapeSelector(value);
    }

    return value.replace(/([ !"#$%&'()*+,./:;<=>?@[\\\]^`{|}~])/g, "\\$1");
  }

  function initCustomCartQuantity() {
    $(".cart-custom-item__quantity .quantity").each(function () {
      const $quantity = $(this);

      if ($quantity.hasClass("cart-qty-initialized")) {
        return;
      }

      $quantity.addClass("cart-qty-initialized");

      $quantity.prepend(
        '<button type="button" class="cart-qty-button cart-qty-button--minus">-</button>',
      );

      $quantity.append(
        '<button type="button" class="cart-qty-button cart-qty-button--plus">+</button>',
      );
    });
  }

  function syncDuplicateCartQuantityInputs($input) {
    const name = $input.attr("name");

    if (!name) {
      return;
    }

    const $item = $input.closest(".cart-custom-item");

    if (!$item.length) {
      return;
    }

    const value = $input.val();

    $item
      .find('input.qty[name="' + escapeSelector(name) + '"]')
      .not($input)
      .val(value);
  }

  function syncVisibleCartQuantityInputs() {
    $(".cart-custom-item").each(function () {
      const $item = $(this);

      const $inputs = $item.find(
        '.cart-custom-item__quantity input.qty[name^="cart["]',
      );

      if ($inputs.length < 2) {
        return;
      }

      const $visibleInput = $inputs
        .filter(function () {
          return $(this).closest(".cart-custom-item__quantity").is(":visible");
        })
        .first();

      const $source = $visibleInput.length ? $visibleInput : $inputs.first();

      $inputs.val($source.val());
    });
  }

  function triggerCartUpdate() {
    const $updateButton = $('button[name="update_cart"]');

    syncVisibleCartQuantityInputs();

    $updateButton.prop("disabled", false);

    clearTimeout(window.talkorusCartUpdateTimer);

    window.talkorusCartUpdateTimer = setTimeout(function () {
      syncVisibleCartQuantityInputs();

      $updateButton.prop("disabled", false);
      $updateButton.trigger("click");
    }, 500);
  }

  $(document).on(
    "click",
    ".cart-qty-button--minus, .cart-qty-button--plus",
    function () {
      const $button = $(this);
      const $quantity = $button.closest(".quantity");
      const $input = $quantity.find("input.qty");

      const currentValue = parseFloat($input.val()) || 0;
      const min = parseFloat($input.attr("min")) || 0;
      const max = parseFloat($input.attr("max")) || 999999;
      const step = parseFloat($input.attr("step")) || 1;

      let newValue = currentValue;

      if ($button.hasClass("cart-qty-button--plus")) {
        newValue = currentValue + step;
      } else {
        newValue = currentValue - step;
      }

      if (newValue < min) {
        newValue = min;
      }

      if (newValue > max) {
        newValue = max;
      }

      $input.val(newValue);

      syncDuplicateCartQuantityInputs($input);

      $input.trigger("change");
    },
  );

  $(document).on(
    "change input",
    ".cart-custom-item__quantity input.qty",
    function () {
      const $input = $(this);

      syncDuplicateCartQuantityInputs($input);
      triggerCartUpdate();
    },
  );

  $(document.body).on("updated_cart_totals updated_wc_div", function () {
    initCustomCartQuantity();
    syncVisibleCartQuantityInputs();
  });

  initCustomCartQuantity();
  syncVisibleCartQuantityInputs();
});

jQuery(function ($) {
  function getCartItemAttributes($item) {
    const attributes = {};

    $item.find(".cart-variation-editor__select").each(function () {
      const $select = $(this);
      const attributeName = $select.data("attribute-name");
      const value = $select.val();

      if (attributeName && value) {
        attributes[attributeName] = value;
      }
    });

    return attributes;
  }

  function updateCartVariation($item) {
    const cartItemKey = $item.data("cart-item-key");
    const productId = $item.data("product-id");
    const attributes = getCartItemAttributes($item);

    if (!cartItemKey || !productId || !Object.keys(attributes).length) {
      return;
    }

    $item.addClass("cart-custom-item--loading");
    $item.find(".cart-variation-editor__select").prop("disabled", true);

    $.ajax({
      url: talkorusCartVariation.ajaxUrl,
      type: "POST",
      dataType: "json",
      data: {
        action: "talkorus_update_cart_item_variation",
        nonce: talkorusCartVariation.nonce,
        cart_item_key: cartItemKey,
        product_id: productId,
        attributes: attributes,
      },
      success: function (response) {
        if (!response || !response.success) {
          const message =
            response && response.data && response.data.message
              ? response.data.message
              : "Не удалось обновить вариацию.";

          alert(message);
          window.location.reload();
          return;
        }

        if (response.data.needs_reload) {
          window.location.reload();
          return;
        }

        $item.attr("data-cart-item-key", response.data.new_cart_item_key);
        $item.data("cart-item-key", response.data.new_cart_item_key);

        $item.find(".cart-custom-item__price").html(response.data.price_html);
        $item
          .find(".cart-custom-item__subtotal")
          .html(response.data.subtotal_html);

        $item
          .find(".cart-custom-item__remove-link")
          .attr("href", response.data.remove_url);

        $(".cart-custom-summary__total strong").html(
          response.data.cart_total_html,
        );
        $(".cart-custom-summary__count").text(response.data.cart_count_text);

        $(document.body).trigger("wc_fragment_refresh");
      },
      error: function () {
        alert("Ошибка обновления вариации.");
        window.location.reload();
      },
      complete: function () {
        $item.removeClass("cart-custom-item--loading");
        $item.find(".cart-variation-editor__select").prop("disabled", false);
      },
    });
  }

  $(document).on("change", ".cart-variation-editor__select", function () {
    const $item = $(this).closest(".cart-custom-item");

    updateCartVariation($item);
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".product-tabs__nav-link");

  if (!tabs.length) {
    return;
  }

  tabs.forEach(function (tabLink) {
    tabLink.addEventListener("click", function (event) {
      event.preventDefault();

      const targetId = tabLink.getAttribute("href");

      if (!targetId) {
        return;
      }

      const tabsWrapper = tabLink.closest(".product-tabs");

      if (!tabsWrapper) {
        return;
      }

      tabsWrapper
        .querySelectorAll(".product-tabs__nav-item")
        .forEach(function (item) {
          item.classList.remove("active");
        });

      tabsWrapper
        .querySelectorAll(".product-tabs__panel")
        .forEach(function (panel) {
          panel.classList.remove("active");
          panel.style.display = "none";
        });

      tabLink.closest(".product-tabs__nav-item").classList.add("active");

      const targetPanel = tabsWrapper.querySelector(targetId);

      if (targetPanel) {
        targetPanel.classList.add("active");
        targetPanel.style.display = "block";
      }
    });
  });
});

jQuery(function ($) {
  function initSingleProductQuantity() {
    $(".single-product-custom .quantity").each(function () {
      const $quantity = $(this);

      if ($quantity.hasClass("single-product-qty-initialized")) {
        return;
      }

      $quantity.addClass("single-product-qty-initialized");

      $quantity.prepend(
        '<button type="button" class="single-product-qty-button single-product-qty-button--minus">-</button>',
      );
      $quantity.append(
        '<button type="button" class="single-product-qty-button single-product-qty-button--plus">+</button>',
      );
    });
  }

  $(document).on(
    "click",
    ".single-product-qty-button--minus, .single-product-qty-button--plus",
    function () {
      const $button = $(this);
      const $quantity = $button.closest(".quantity");
      const $input = $quantity.find("input.qty");

      const currentValue = parseFloat($input.val()) || 1;
      const min = parseFloat($input.attr("min")) || 1;
      const max = parseFloat($input.attr("max")) || 999999;
      const step = parseFloat($input.attr("step")) || 1;

      let newValue = currentValue;

      if ($button.hasClass("single-product-qty-button--plus")) {
        newValue = currentValue + step;
      } else {
        newValue = currentValue - step;
      }

      if (newValue < min) {
        newValue = min;
      }

      if (newValue > max) {
        newValue = max;
      }

      $input.val(newValue).trigger("change");
    },
  );

  initSingleProductQuantity();

  $(document.body).on("found_variation reset_data", function () {
    initSingleProductQuantity();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const videoButtons = document.querySelectorAll(
    ".about-us__video[data-video-src]",
  );
  const modal = document.querySelector("#videoModal");

  if (!videoButtons.length || !modal) {
    return;
  }

  const modalVideo = modal.querySelector(".video-modal__video");
  const modalSource = modal.querySelector(".video-modal__video source");
  const closeButtons = modal.querySelectorAll("[data-video-close]");

  function openVideo(videoSrc) {
    if (!videoSrc || !modalVideo || !modalSource) {
      return;
    }

    modalSource.src = videoSrc;
    modalVideo.load();

    modal.classList.add("active");
    modal.setAttribute("aria-hidden", "false");

    document.body.classList.add("hold");

    modalVideo.play().catch(function () {});
  }

  function closeVideo() {
    modal.classList.remove("active");
    modal.setAttribute("aria-hidden", "true");

    document.body.classList.remove("hold");

    if (modalVideo) {
      modalVideo.pause();
      modalVideo.currentTime = 0;
    }

    if (modalSource) {
      modalSource.src = "";
    }
  }

  videoButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      openVideo(button.dataset.videoSrc);
    });
  });

  closeButtons.forEach(function (button) {
    button.addEventListener("click", closeVideo);
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && modal.classList.contains("active")) {
      closeVideo();
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const projectGallery = document.querySelector(".single-project-gallery");

  if (!projectGallery) {
    return;
  }

  new Swiper(projectGallery, {
    loop: true,
    speed: 600,
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
      nextEl: projectGallery.querySelector(
        ".single-project-gallery__nav--next",
      ),
      prevEl: projectGallery.querySelector(
        ".single-project-gallery__nav--prev",
      ),
    },
  });
});
