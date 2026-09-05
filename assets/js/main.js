/**
 * Castejon Store - Main JavaScript
 * Alta performance, navegação fluida estilo The Greg's Exclusive
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Sticky Header
  const siteHeader = document.querySelector('.cj-site-header');
  if (siteHeader) {
    const handleScroll = () => {
      if (window.scrollY > 35) {
        siteHeader.classList.add('is-scrolled');
      } else {
        siteHeader.classList.remove('is-scrolled');
      }
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  // 2. Announcement Bar Rotativa
  const adBar = document.getElementById('cj-announcement-bar');
  if (adBar) {
    const items = adBar.querySelectorAll('.cj-announcement-item');
    const prevBtn = adBar.querySelector('.cj-prev');
    const nextBtn = adBar.querySelector('.cj-next');
    const totalItems = items.length;
    let currentIndex = 0;
    let timer = null;

    const showSlide = (index) => {
      items.forEach((item, i) => {
        item.classList.toggle('is-active', i === index);
      });
      currentIndex = index;
    };

    const nextSlide = () => {
      const nextIndex = (currentIndex + 1) % totalItems;
      showSlide(nextIndex);
    };

    const prevSlide = () => {
      const prevIndex = (currentIndex - 1 + totalItems) % totalItems;
      showSlide(prevIndex);
    };

    const startTimer = () => {
      stopTimer();
      timer = setInterval(nextSlide, 4500);
    };

    const stopTimer = () => {
      if (timer) {
        clearInterval(timer);
        timer = null;
      }
    };

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        nextSlide();
        startTimer();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        prevSlide();
        startTimer();
      });
    }

    // Touch swipe na announcement bar
    let adStartX = 0;
    adBar.addEventListener('touchstart', (e) => {
      adStartX = e.touches[0].clientX;
    }, { passive: true });

    adBar.addEventListener('touchend', (e) => {
      const adEndX = e.changedTouches[0].clientX;
      const diff = adStartX - adEndX;
      if (Math.abs(diff) > 30) {
        if (diff > 0) nextSlide();
        else prevSlide();
        startTimer();
      }
    }, { passive: true });

    adBar.addEventListener('mouseenter', stopTimer);
    adBar.addEventListener('mouseleave', startTimer);
    startTimer();
  }

  // 3. Mobile Menu Drawer
  const mobileToggle = document.querySelector('.cj-mobile-toggle');
  const mobileNav = document.querySelector('.cj-mobile-nav');
  const mobileBackdrop = document.querySelector('.cj-mobile-backdrop');
  const mobileClose = document.querySelector('.cj-mobile-close');

  const openMobileMenu = () => {
    if (mobileNav && mobileBackdrop) {
      mobileNav.classList.add('is-active');
      mobileBackdrop.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }
  };

  const closeMobileMenu = () => {
    if (mobileNav && mobileBackdrop) {
      mobileNav.classList.remove('is-active');
      mobileBackdrop.classList.remove('is-active');
      document.body.style.overflow = '';
    }
  };

  if (mobileToggle) mobileToggle.addEventListener('click', openMobileMenu);
  if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
  if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileMenu);

  // 4. Side-Cart Drawer (Minicart Lateral AJAX)
  const cartDrawer = document.getElementById('cj-cart-drawer');
  const cartBackdrop = document.getElementById('cj-cart-drawer-backdrop');
  const cartClose = document.getElementById('cj-cart-drawer-close');
  const cartToggles = document.querySelectorAll('.cj-cart-toggle, .cj-cart-btn');

  const openCartDrawer = (e) => {
    if (e) e.preventDefault();
    if (cartDrawer && cartBackdrop) {
      closeMobileMenu();
      cartDrawer.classList.add('is-active');
      cartBackdrop.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }
  };

  const closeCartDrawer = () => {
    if (cartDrawer && cartBackdrop) {
      cartDrawer.classList.remove('is-active');
      cartBackdrop.classList.remove('is-active');
      document.body.style.overflow = '';
    }
  };

  cartToggles.forEach(btn => btn.addEventListener('click', openCartDrawer));
  if (cartClose) cartClose.addEventListener('click', closeCartDrawer);
  if (cartBackdrop) cartBackdrop.addEventListener('click', closeCartDrawer);

  // Fecha com ESC
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeMobileMenu();
      closeCartDrawer();
    }
  });

  // Fecha drawer se clicar no botão "Explorar Perfumes"
  document.addEventListener('click', (e) => {
    if (e.target.closest('.cj-drawer-close-action')) {
      closeCartDrawer();
    }
  });

  // 5. Interações no Carrinho Lateral (Aumentar, Diminuir, Remover via AJAX)
  const ajaxUrl = (window.castejonData && window.castejonData.ajaxUrl) ? window.castejonData.ajaxUrl : '/wp-admin/admin-ajax.php';

  const updateDrawerFragments = (fragments) => {
    if (!fragments) return;
    Object.keys(fragments).forEach((selector) => {
      const el = document.querySelector(selector);
      if (el) {
        el.outerHTML = fragments[selector];
      }
    });
  };

  document.addEventListener('click', async (e) => {
    // Quantidade [+] ou [-]
    const qtyBtn = e.target.closest('.cj-qty-btn');
    if (qtyBtn) {
      e.preventDefault();
      const control = qtyBtn.closest('.cj-drawer-qty-control');
      const cartKey = control ? control.dataset.cartKey : null;
      const valEl = control ? control.querySelector('.cj-qty-val') : null;
      if (!cartKey || !valEl) return;

      let currentVal = parseInt(valEl.textContent.trim(), 10) || 1;
      let newVal = qtyBtn.classList.contains('cj-qty-plus') ? currentVal + 1 : currentVal - 1;

      control.style.opacity = '0.5';
      control.style.pointerEvents = 'none';

      const formData = new FormData();
      formData.append('action', 'castejon_update_cart_drawer_qty');
      formData.append('cart_item_key', cartKey);
      formData.append('quantity', newVal);

      try {
        const response = await fetch(ajaxUrl, { method: 'POST', body: formData });
        const data = await response.json();
        if (data && data.fragments) {
          updateDrawerFragments(data.fragments);
        } else {
          // Se o WooCommerce disparar refresh padrão
          if (window.jQuery) window.jQuery(document.body).trigger('wc_fragment_refresh');
        }
      } catch (err) {
        if (window.jQuery) window.jQuery(document.body).trigger('wc_fragment_refresh');
      }
    }

    // Remover Item
    const removeBtn = e.target.closest('.cj-drawer-remove-btn');
    if (removeBtn) {
      e.preventDefault();
      const cartKey = removeBtn.dataset.cartKey;
      if (!cartKey) return;

      const itemRow = removeBtn.closest('.cj-drawer-item');
      if (itemRow) itemRow.style.opacity = '0.3';

      const formData = new FormData();
      formData.append('action', 'castejon_remove_cart_drawer_item');
      formData.append('cart_item_key', cartKey);

      try {
        const response = await fetch(ajaxUrl, { method: 'POST', body: formData });
        const data = await response.json();
        if (data && data.fragments) {
          updateDrawerFragments(data.fragments);
        } else {
          if (window.jQuery) window.jQuery(document.body).trigger('wc_fragment_refresh');
        }
      } catch (err) {
        if (window.jQuery) window.jQuery(document.body).trigger('wc_fragment_refresh');
      }
    }
  });

  // Abre o drawer automaticamente quando um produto é adicionado ao carrinho via WooCommerce AJAX
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
      openCartDrawer();
      if (fragments) {
        updateDrawerFragments(fragments);
      }
    });
  }

  // 6. Observer de Reveal Suave
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08 });

    const animatedCards = document.querySelectorAll('.cj-product-card, .cj-category-card, .cj-benefit-card, .cj-decant-card');
    animatedCards.forEach((el, index) => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(16px)';
      el.style.transition = `opacity 0.45s cubic-bezier(0.16, 1, 0.3, 1) ${(index % 4) * 0.06}s, transform 0.45s cubic-bezier(0.16, 1, 0.3, 1) ${(index % 4) * 0.06}s`;
      observer.observe(el);
    });
  }

  // 7. Slider de Imagens da Home (Vanilla, Autoplay, Touch & Dots)
  const homeSlider = document.getElementById('cjHomeSlider');
  if (homeSlider) {
    const track = homeSlider.querySelector('.cj-slider-track');
    const slides = homeSlider.querySelectorAll('.cj-slide');
    const dots = homeSlider.querySelectorAll('.cj-slider-dot');
    const prevBtn = homeSlider.querySelector('.cj-slider-prev');
    const nextBtn = homeSlider.querySelector('.cj-slider-next');
    const totalSlides = slides.length;
    let currentSlide = 0;
    let autoPlayTimer = null;
    const intervalTime = 5500;

    function goToSlide(index) {
      if (index < 0) index = totalSlides - 1;
      if (index >= totalSlides) index = 0;
      currentSlide = index;

      if (track) {
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
      }

      slides.forEach((slide, i) => {
        slide.classList.toggle('is-active', i === currentSlide);
      });

      dots.forEach((dot, i) => {
        dot.classList.toggle('is-active', i === currentSlide);
      });
    }

    function nextSlide() {
      goToSlide(currentSlide + 1);
    }

    function prevSlide() {
      goToSlide(currentSlide - 1);
    }

    function startAutoPlay() {
      stopAutoPlay();
      autoPlayTimer = setInterval(nextSlide, intervalTime);
    }

    function stopAutoPlay() {
      if (autoPlayTimer) {
        clearInterval(autoPlayTimer);
        autoPlayTimer = null;
      }
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        nextSlide();
        startAutoPlay();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        prevSlide();
        startAutoPlay();
      });
    }

    dots.forEach((dot) => {
      dot.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const target = parseInt(e.currentTarget.getAttribute('data-slide-target'), 10);
        goToSlide(target);
        startAutoPlay();
      });
    });

    homeSlider.addEventListener('mouseenter', stopAutoPlay);
    homeSlider.addEventListener('mouseleave', startAutoPlay);

    // Teclado (setas esquerda e direita)
    window.addEventListener('keydown', (e) => {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
      if (e.key === 'ArrowRight') {
        nextSlide();
        startAutoPlay();
      } else if (e.key === 'ArrowLeft') {
        prevSlide();
        startAutoPlay();
      }
    });

    // Touch Swipe no Celular
    let touchStartX = 0;
    homeSlider.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
      stopAutoPlay();
    }, { passive: true });

    homeSlider.addEventListener('touchend', (e) => {
      const touchEndX = e.changedTouches[0].screenX;
      const diff = touchStartX - touchEndX;
      if (Math.abs(diff) > 35) {
        if (diff > 0) nextSlide();
        else prevSlide();
      }
      startAutoPlay();
    }, { passive: true });

    // Drag com Mouse no Desktop
    let isMouseDown = false;
    let mouseStartX = 0;

    homeSlider.addEventListener('mousedown', (e) => {
      if (e.target.closest('.cj-slider-btn') || e.target.closest('.cj-slider-dot')) return;
      isMouseDown = true;
      mouseStartX = e.clientX;
      stopAutoPlay();
    });

    window.addEventListener('mouseup', (e) => {
      if (!isMouseDown) return;
      isMouseDown = false;
      const mouseEndX = e.clientX;
      const diff = mouseStartX - mouseEndX;
      if (Math.abs(diff) > 50) {
        if (diff > 0) nextSlide();
        else prevSlide();
      }
      startAutoPlay();
    });

    // Inicializa posição e autoplay
    goToSlide(0);
    startAutoPlay();
  }

  // 8. Newsletter VIP (Feedback inline)
  const newsletterForm = document.querySelector('.cj-newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const emailInput = newsletterForm.querySelector('input[type="email"]');
      if (emailInput && emailInput.value) {
        newsletterForm.innerHTML = '<div class="cj-newsletter-success" style="color: var(--gregs-gold); font-weight: 700; font-size: 0.95rem; padding: 12px 0;">✨ Inscrição confirmada com sucesso! Você receberá ofertas e lançamentos exclusivos.</div>';
      }
    });
  }
});

