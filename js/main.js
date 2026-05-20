jQuery(document).ready(function ($) {
  $(".about-info__item.active .about-info__body").each(function () {
    $(this).css("max-height", this.scrollHeight + "px");
  });

  $(".about-info__head").on("click", function () {
    const $item = $(this).closest(".about-info__item");
    const $body = $item.find(".about-info__body");
    const isActive = $item.hasClass("active");

    if (isActive) {
      $body.css("max-height", 0);
      $item.removeClass("active");
    } else {
      $(".about-info__item.active").each(function () {
        $(this).removeClass("active");
        $(this).find(".about-info__body").css("max-height", 0);
      });

      $item.addClass("active");
      $body.css("max-height", $body[0].scrollHeight + "px");
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
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: {
          nextEl: nextBtn,
          prevEl: prevBtn,
        },
      });
    }
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

  function triggerCartUpdate() {
    const $updateButton = $('button[name="update_cart"]');

    $updateButton.prop("disabled", false);

    clearTimeout(window.talkorusCartUpdateTimer);

    window.talkorusCartUpdateTimer = setTimeout(function () {
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

      $input.val(newValue).trigger("change");
    },
  );

  $(document).on(
    "change",
    ".cart-custom-item__quantity input.qty",
    function () {
      triggerCartUpdate();
    },
  );

  $(document.body).on("updated_cart_totals updated_wc_div", function () {
    initCustomCartQuantity();
  });

  initCustomCartQuantity();
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
