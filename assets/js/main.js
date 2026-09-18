/**
 * Castejon Store - Main JavaScript
 * Alta performance, navegaÃ§Ã£o fluida estilo The Greg's Exclusive
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
  const mobileToggles = document.querySelectorAll('.cj-mobile-toggle, .cj-mobile-search-toggle');
  const mobileNav = document.querySelector('.cj-mobile-nav');
  const mobileBackdrop = document.querySelector('.cj-mobile-backdrop');
  const mobileClose = document.querySelector('.cj-mobile-close');

  const openMobileMenu = (e) => {
    if (mobileNav && mobileBackdrop) {
      mobileNav.classList.add('is-active');
      mobileBackdrop.classList.add('is-active');
      document.body.style.overflow = 'hidden';

      if (e && e.currentTarget && e.currentTarget.classList.contains('cj-mobile-search-toggle')) {
        setTimeout(() => {
          const searchInput = mobileNav.querySelector('input[type="search"]');
          if (searchInput) searchInput.focus();
        }, 300);
      }
    }
  };

  const closeMobileMenu = () => {
    if (mobileNav && mobileBackdrop) {
      mobileNav.classList.remove('is-active');
      mobileBackdrop.classList.remove('is-active');
      document.body.style.overflow = '';
    }
  };

  if (mobileToggles.length) mobileToggles.forEach(btn => btn.addEventListener('click', openMobileMenu));
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

  // Fecha drawer se clicar no botÃ£o "Explorar Perfumes"
  document.addEventListener('click', (e) => {
    if (e.target.closest('.cj-drawer-close-action')) {
      closeCartDrawer();
    }
  });

  // 5. Interações no Carrinho Lateral (Aumentar, Diminuir, Remover via AJAX)
  const ajaxUrl = (window.castejonData && window.castejonData.ajaxUrl) ? window.castejonData.ajaxUrl : '/wp-admin/admin-ajax.php';
  const ajaxNonce = (window.castejonData && window.castejonData.nonce) ? window.castejonData.nonce : '';

  // Abre automaticamente a sacola lateral quando um produto é adicionado ao carrinho
  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', () => {
      openCartDrawer();
    });
  }

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
      if (ajaxNonce) formData.append('nonce', ajaxNonce);

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
      if (ajaxNonce) formData.append('nonce', ajaxNonce);

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

  // Abre o drawer automaticamente quando um produto Ã© adicionado ao carrinho.
  // Alguns plugins de variaÃ§Ã£o fazem o add via POST+redirect (sem AJAX e sem
  // eventos padrÃ£o do WC), entÃ£o usamos: flag em sessionStorage no clique,
  // que Ã© lida no carregamento da prÃ³xima pÃ¡gina; + added_to_cart; + observer
  // no contador para os casos AJAX.
  const cjClearJustAdded = () => { try { sessionStorage.removeItem('cj-just-added'); } catch (e) { /* ignore */ } };
  const cjOpenCartFromAdd = () => { openCartDrawer(); cjClearJustAdded(); };
  let cjAddClickedAt = 0;

  document.addEventListener('click', (e) => {
    if (e.target.closest('.single_add_to_cart_button:not(.disabled):not(.wc-variation-is-unavailable)')) {
      try { sessionStorage.setItem('cj-just-added', '1'); } catch (e2) { /* ignore */ }
      cjAddClickedAt = Date.now();
    }
  });

  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
      cjOpenCartFromAdd();
      cjBadgePop();
      if (fragments) {
        updateDrawerFragments(fragments);
      }
    });
  }

  const cjBadgePop = () => {
    const badge = document.querySelector('.cj-cart-badge');
    if (!badge) return;
    badge.classList.remove('cj-badge-pop');
    void badge.offsetWidth;
    badge.classList.add('cj-badge-pop');
  };

  const cjCartCountEl = document.querySelector('.cj-cart-count');
  if (cjCartCountEl && 'MutationObserver' in window) {
    let cjPrevCount = parseInt(cjCartCountEl.textContent, 10) || 0;

    new MutationObserver(() => {
      const countEl = document.querySelector('.cj-cart-count');
      if (!countEl) return;
      const nowCount = parseInt(countEl.textContent, 10) || 0;
      if (nowCount > cjPrevCount && (Date.now() - cjAddClickedAt) < 5000) {
        cjBadgePop();
        cjOpenCartFromAdd();
      }
      cjPrevCount = nowCount;
    }).observe(document.body, { childList: true, characterData: true, subtree: true });
  }

  // Fallback pÃ³s-reload: o POST+redirect mantÃ©m a flag em sessionStorage
  try {
    if (sessionStorage.getItem('cj-just-added') === '1') {
      cjOpenCartFromAdd();
    }
  } catch (e) { /* ignore */ }

  // 6. Observer de Reveal Suave
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-revealed');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08 });

    const animatedCards = document.querySelectorAll('.cj-product-card, .cj-category-card, .cj-benefit-card, .cj-decant-card');
    animatedCards.forEach((el, index) => {
      el.style.transitionDelay = `${(index % 4) * 0.06}s`;
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
    const intervalTime = 12000;

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

    // Inicializa posiÃ§Ã£o e autoplay
    goToSlide(0);
    startAutoPlay();
  }

  // 9. PDP: PreÃ§o/PIX/Parcelas reage Ã  variaÃ§Ã£o selecionada
  const pdpVariationForm = document.querySelector('.cj-single-form-wrapper form.cart');
  if (pdpVariationForm && window.jQuery) {
    const priceBox = document.querySelector('.cj-single-price');
    const pixEl = document.querySelector('.cj-single-pix-box .cj-pix-price');
    const instEl = document.querySelector('.cj-single-installments');

    // PreÃ§os base (para restaurar quando resetar a variaÃ§Ã£o)
    const baseHtml = priceBox ? priceBox.innerHTML : '';
    const basePix = pixEl ? pixEl.textContent : '';
    const baseInst = instEl ? instEl.innerHTML : '';

    const cjFmtBRL = (v) => v.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    const cjApplyVariationPrice = (price) => {
      const pix = price * 0.95;
      if (pixEl) pixEl.textContent = cjFmtBRL(pix);
      if (instEl) {
        let max = 12;
        let val = price / max;
        if (val < 15) {
          max = Math.max(1, Math.floor(price / 15));
          if (max <= 1) { instEl.innerHTML = ''; return; }
          val = price / max;
        }
        instEl.innerHTML = 'ou ' + max + 'x de ' + cjFmtBRL(val) + ' sem juros';
      }
    };

    window.jQuery(pdpVariationForm)
      .on('found_variation', function (e, variation) {
        if (variation && variation.display_price) {
          cjApplyVariationPrice(variation.display_price);
          if (priceBox && variation.price_html) priceBox.innerHTML = variation.price_html;
        }
      })
      .on('reset_data', function () {
        if (priceBox) priceBox.innerHTML = baseHtml;
        if (pixEl) pixEl.textContent = basePix;
        if (instEl) instEl.innerHTML = baseInst;
      });
  }

  // 10. Slider de Avaliações (autoplay horizontal, loop sem emenda)
  const cjReviewsRow = document.querySelector('.cj-reviews-widget .ti-reviews-container-wrapper');
  if (cjReviewsRow) {
    const cjRevItems = cjReviewsRow.querySelectorAll('.ti-review-item');
    const cjRevTotal = cjRevItems.length;
    const cjRevStep = Math.round((cjRevItems[0] ? cjRevItems[0].getBoundingClientRect().width : 340) + 16);
    const cjRevVisible = Math.max(1, Math.floor(cjReviewsRow.clientWidth / cjRevStep));
    const cjRevMaxIdx = Math.max(0, cjRevTotal - cjRevVisible);
    let cjRevIndex = 0;
    let cjRevTimer = null;
    const cjRevReduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Clona cards no final: ao avançar uma posição além do último card original,
    // o conteúdo da janela é idêntico ao início — o reset volta invisível.
    for (let i = 0; i < cjRevVisible + 1 && i < cjRevTotal; i++) {
      const cjRevClone = cjRevItems[i].cloneNode(true);
      cjRevClone.setAttribute('aria-hidden', 'true');
      cjReviewsRow.appendChild(cjRevClone);
    }

    // Posições reais de cada card (larguras podem variar — evita snap/jitter)
    const cjRevPositions = Array.from(cjReviewsRow.querySelectorAll('.ti-review-item')).map(function (el) {
      return Math.round(el.getBoundingClientRect().left - cjReviewsRow.getBoundingClientRect().left);
    });

    // Passos: 0..maxIdx (originais) + 1 extra no clone-0 (loop invisível)
    const cjRevSteps = cjRevMaxIdx + 2;

    const cjRevGo = (i) => {
      if (cjRevSteps <= 1) return;
      const idx = i % cjRevSteps;
      const wrap = idx === 0 && i > 0;
      cjRevIndex = idx;
      cjReviewsRow.scrollTo({ left: wrap ? 0 : cjRevPositions[idx], behavior: wrap ? 'auto' : 'smooth' });
    };

    const cjRevNext = () => cjRevGo(cjRevIndex + 1);
    const cjRevStart = () => {
      cjRevStop();
      if (cjRevReduceMotion || cjRevSteps <= 1) return;
      cjRevTimer = setInterval(cjRevNext, 4500);
    };
    const cjRevStop = () => {
      if (cjRevTimer) {
        clearInterval(cjRevTimer);
        cjRevTimer = null;
      }
    };

    cjReviewsRow.addEventListener('mouseenter', cjRevStop);
    cjReviewsRow.addEventListener('mouseleave', cjRevStart);
    cjReviewsRow.addEventListener('touchstart', cjRevStop, { passive: true });
    cjReviewsRow.addEventListener('touchend', () => setTimeout(cjRevStart, 3000), { passive: true });
    cjRevStart();
  }

  // 11. Busca com sugestÃµes AJAX + Quickshop
  document.querySelectorAll('.cj-search-box').forEach((form) => {
    const input = form.querySelector('input[type="search"]');
    if (!input) return;
    const wrap = document.createElement('div');
    wrap.className = 'cj-search-suggest';
    form.parentElement.appendChild(wrap);
    let cjSearchTimer = null;

    const hideSuggest = () => wrap.classList.remove('is-open');

    const doSearch = async () => {
      const term = input.value.trim();
      if (term.length < 2) { hideSuggest(); return; }
      const fd = new FormData();
      fd.append('action', 'castejon_search_suggest');
      fd.append('term', term);
      if (ajaxNonce) fd.append('nonce', ajaxNonce);
      try {
        const res = await fetch(ajaxUrl, { method: 'POST', body: fd });
        const items = await res.json();
        if (!Array.isArray(items) || items.length === 0) {
          wrap.innerHTML = '<div class="cj-search-suggest-empty">Nenhum produto encontrado</div>';
          wrap.classList.add('is-open');
          return;
        }
        wrap.innerHTML = items.map((it) =>
          '<a class="cj-search-suggest-item" href="' + it.url + '">' +
          '<img src="' + it.img + '" alt="" loading="lazy" width="40" height="40">' +
          '<span class="cj-search-suggest-name">' + it.title + '</span>' +
          '<span class="cj-search-suggest-price">' + it.price + '</span></a>'
        ).join('') +
          '<a class="cj-search-suggest-all" href="' + (form.getAttribute('action') || '/') + '?s=' + encodeURIComponent(term) + '&post_type=product">Ver todos os resultados</a>';
        wrap.classList.add('is-open');
      } catch (e) { hideSuggest(); }
    };

    input.addEventListener('input', () => {
      clearTimeout(cjSearchTimer);
      cjSearchTimer = setTimeout(doSearch, 300);
    });
    input.addEventListener('focus', () => { if (input.value.trim().length >= 2) doSearch(); });
    document.addEventListener('click', (e) => { if (!wrap.contains(e.target) && e.target !== input) hideSuggest(); });
    input.addEventListener('keydown', (e) => { if (e.key === 'Escape') hideSuggest(); });
  });

  const cjQSModal = document.getElementById('cj-quickshop-modal');
  const cjQSBackdrop = document.getElementById('cj-quickshop-backdrop');
  const cjQSContent = document.getElementById('cj-quickshop-content');
  const cjQSClose = document.getElementById('cj-quickshop-close');

  const openQS = () => {
    if (cjQSModal && cjQSBackdrop) {
      cjQSModal.classList.add('is-active');
      cjQSBackdrop.classList.add('is-active');
      document.body.style.overflow = 'hidden';
    }
  };
  const closeQS = () => {
    if (cjQSModal && cjQSBackdrop) {
      cjQSModal.classList.remove('is-active');
      cjQSBackdrop.classList.remove('is-active');
      document.body.style.overflow = '';
    }
  };

  document.addEventListener('click', async (e) => {
    const btn = e.target.closest('.cj-quickshop-btn');
    if (!btn) return;
    e.preventDefault();
    const fd = new FormData();
    fd.append('action', 'castejon_quickshop');
    fd.append('product_id', btn.dataset.productId);
    if (ajaxNonce) fd.append('nonce', ajaxNonce);

    if (cjQSContent) cjQSContent.innerHTML = '<div class="cj-quickshop-loading">Carregando produto...</div>';
    openQS();
    try {
      const res = await fetch(ajaxUrl, { method: 'POST', body: fd });
      const data = await res.json();
      if (data && data.success && cjQSContent) {
        cjQSContent.innerHTML = data.data.html;
        if (window.jQuery) {
          window.jQuery('#cj-quickshop-content form.variations_form').wc_variation_form();
        }
      } else if (cjQSContent) {
        cjQSContent.innerHTML = '<p>Não foi possível carregar o produto.</p>';
      }
    } catch (err) {
      if (cjQSContent) cjQSContent.innerHTML = '<p>Erro ao carregar o produto.</p>';
    }
  });

  if (cjQSClose) cjQSClose.addEventListener('click', closeQS);
  if (cjQSBackdrop) cjQSBackdrop.addEventListener('click', closeQS);
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeQS(); });

  // 8. Newsletter VIP (Submissão Assíncrona Real com Feedback)
  const newsletterForm = document.querySelector('.cj-newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const emailInput = newsletterForm.querySelector('input[type="email"]');
      const submitBtn = newsletterForm.querySelector('button[type="submit"]');
      if (!emailInput || !emailInput.value.trim()) return;

      const email = emailInput.value.trim();
      const origBtnText = submitBtn ? submitBtn.innerHTML : 'Cadastrar';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Enviando...';
      }

      const fd = new FormData();
      fd.append('action', 'castejon_subscribe_newsletter');
      fd.append('email', email);
      if (ajaxNonce) fd.append('nonce', ajaxNonce);

      try {
        const res = await fetch(ajaxUrl, { method: 'POST', body: fd });
        const data = await res.json();
        if (data && data.success) {
          newsletterForm.innerHTML = '<div class="cj-newsletter-success" style="color: var(--gregs-gold); font-weight: 700; font-size: 0.95rem; padding: 14px 0;">' + (data.data && data.data.message ? data.data.message : '✨ Inscrição confirmada com sucesso!') + '</div>';
        } else {
          alert((data && data.data && data.data.message) ? data.data.message : 'Erro ao cadastrar e-mail. Tente novamente.');
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = origBtnText;
          }
        }
      } catch (err) {
        alert('Erro ao conectar ao servidor. Verifique sua conexão e tente novamente.');
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origBtnText;
        }
      }
    });
  }

  // 12. Defesa: corrige largura da galeria de variações (wvg/slick) quando
  // plugins de imagem (ex.: WebP Express <picture>) quebram a medição e o
  // slide fica com largura de miniatura (foto pequena no canto).
  const cjFixGalleryWidth = () => {
    document.querySelectorAll('.cj-gallery-wrapper').forEach((wrap) => {
      const track = wrap.querySelector('.slick-track');
      const slides = wrap.querySelectorAll('.slick-slide');
      if (!track || !slides.length) return;
      const w = Math.round(wrap.getBoundingClientRect().width);
      if (!w) return;
      const first = Math.round(slides[0].getBoundingClientRect().width);
      if (first > 0 && first < w * 0.6) {
        slides.forEach((s) => { s.style.width = w + 'px'; });
        track.style.width = (w * slides.length) + 'px';
        const list = wrap.querySelector('.slick-list');
        if (list) {
          list.style.width = '100%';
          list.style.height = 'auto';
        }
        window.dispatchEvent(new Event('resize'));
      }
    });
  };
  if (document.readyState === 'complete') {
    setTimeout(cjFixGalleryWidth, 1200);
  } else {
    window.addEventListener('load', () => setTimeout(cjFixGalleryWidth, 1200));
  }
  window.addEventListener('load', () => setTimeout(cjFixGalleryWidth, 3000));
  document.addEventListener('change', (e) => {
    if (e.target.closest('.variations_form')) setTimeout(cjFixGalleryWidth, 400);
  });
});

