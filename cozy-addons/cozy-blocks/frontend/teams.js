(function ($) {
  window["cozyBlockTeamsInit"] = (e) => {
    const n = e.replace(/-/gi, "_");
    const blockOptions = window[`cozyTeams_${n}`];
    const teamsClass = `#cozyBlock_${n}`;
    const cozyTeams = document.querySelector(teamsClass);

    const teamsStyles = [
      {
        property: "--cozyTeamsGridTemplateColumns",
        value: blockOptions.gridOptions.displayColumn,
      },
      {
        property: "--cozyTeamsGridGap",
        value: `${blockOptions.gridOptions.columnGap}px`,
      },
      {
        property: "--cozyNavIconSize",
        value: `${blockOptions.carouselOptions.navigation.iconSize}px`,
      },
      {
        property: "--cozyNavWidth",
        value: `${blockOptions.carouselOptions.navigation.iconBoxWidth}px`,
      },
      {
        property: "--cozyNavHeight",
        value: `${blockOptions.carouselOptions.navigation.iconBoxHeight}px`,
      },
      {
        property: "--cozyNavBorderType",
        value: `${blockOptions.carouselOptions.navigation.borderType}`,
      },
      {
        property: "--cozyNavBorderWidth",
        value: `${blockOptions.carouselOptions.navigation.borderWidth}px`,
      },
      {
        property: "--cozyNavBorderColor",
        value: `${blockOptions.carouselOptions.navigation.borderColor}`,
      },
      {
        property: "--cozyNavBorderColorHover",
        value: `${blockOptions.carouselOptions.navigation.borderColorHover}`,
      },
      {
        property: "--cozyNavBorderRadius",
        value: `${blockOptions.carouselOptions.navigation.borderRadius}px`,
      },
      {
        property: "--cozyNavIconColor",
        value: blockOptions.carouselOptions.navigation.color,
      },
      {
        property: "--cozyNavIconColorHover",
        value: blockOptions.carouselOptions.navigation.colorHover,
      },
      {
        property: "--cozyNavBgColor",
        value: blockOptions.carouselOptions.navigation.backgroundColor,
      },
      {
        property: "--cozyNavBgColorHover",
        value: blockOptions.carouselOptions.navigation.backgroundColorHover,
      },
      {
        property: "--cozyPaginationWidth",
        value: `${blockOptions.carouselOptions.pagination.width}px`,
      },
      {
        property: "--cozyPaginationHeight",
        value: `${blockOptions.carouselOptions.pagination.height}px`,
      },
      {
        property: "--cozyPaginationBorderRadius",
        value: `${blockOptions.carouselOptions.pagination.borderRadius}px`,
      },
      {
        property: "--cozyPaginationActiveWidth",
        value: `${blockOptions.carouselOptions.pagination.activeWidth}px`,
      },
      {
        property: "--cozyPaginationActiveBorderRadius",
        value: `${blockOptions.carouselOptions.pagination.activeBorderRadius}px`,
      },
      {
        property: "--cozyPaginationColor",
        value: blockOptions.carouselOptions.pagination.color,
      },
      {
        property: "--cozyPaginationColorHover",
        value: blockOptions.carouselOptions.pagination.colorHover,
      },
      {
        property: "--cozyPaginationActiveColor",
        value: blockOptions.carouselOptions.pagination.activeColor,
      },
      {
        property: "--cozyPaginationActiveColorHover",
        value: blockOptions.carouselOptions.pagination.activeColorHover,
      },
      {
        property: "--cozyPaginationPositionVertical",
        value: `${blockOptions.carouselOptions.pagination.positionVertical}px`,
      },
      {
        property: "--cozyPaginationAlign",
        value: blockOptions.carouselOptions.pagination?.align
          ? blockOptions.carouselOptions.pagination?.align
          : "center",
      },
      {
        property: "--cozyPaginationLeft",
        value:
          blockOptions.carouselOptions.pagination?.align === "left"
            ? blockOptions.carouselOptions.pagination?.left
            : "",
      },
      {
        property: "--cozyPaginationRight",
        value:
          blockOptions.carouselOptions.pagination?.align === "right"
            ? blockOptions.carouselOptions.pagination?.right
            : "",
      },
    ];

    teamsStyles.forEach((style) => {
      cozyTeams.style.setProperty(style.property, style.value);
    });

    const carouselAttr = {
      init: true,
      loop: blockOptions.carouselOptions.sliderOptions.loop,
      speed: blockOptions.carouselOptions.sliderOptions.speed,
      centeredSlides: blockOptions.carouselOptions.sliderOptions.centeredSlides,
      slidesPerView: blockOptions.carouselOptions.sliderOptions.slidesPerView,
      spaceBetween: blockOptions.carouselOptions.sliderOptions.spaceBetween,
      navigation: {
        nextEl: `${teamsClass} .swiper-button-next.cozy-block-button-next`,
        prevEl: `${teamsClass} .swiper-button-prev.cozy-block-button-prev`,
      },
      pagination: {
        clickable: true,
        el: `${teamsClass} .swiper-pagination`,
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        400: {
          slidesPerView: 1,
        },
        767: {
          slidesPerView:
            blockOptions.carouselOptions.sliderOptions.slidesPerView <= 2
              ? blockOptions.carouselOptions.sliderOptions.slidesPerView
              : 2,
        },
        1024: {
          slidesPerView:
            blockOptions.carouselOptions.sliderOptions.slidesPerView <= 3
              ? blockOptions.carouselOptions.sliderOptions.slidesPerView
              : 3,
        },
        1180: {
          slidesPerView:
            blockOptions.carouselOptions.sliderOptions.slidesPerView,
        },
      },
    };

    if (blockOptions.carouselOptions.sliderOptions.autoplay.enabled) {
      carouselAttr.autoplay = {
        ...blockOptions.carouselOptions.sliderOptions.autoplay,
      };
    } else {
      delete carouselAttr.autoplay;
    }

    new Swiper(teamsClass + ".swiper-container", carouselAttr);
  };
})(jQuery);