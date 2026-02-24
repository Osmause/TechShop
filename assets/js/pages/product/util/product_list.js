class ProductList {
    constructor(products, options = {}) {
        this.products = products;
        this.currentPage = 1;
        this.perPage = options.perPage || 20;

        this.listContainer = document.querySelector('[data-component="product-list"]');
        this.paginationContainer = document.getElementById('pagination');
        this.prototypeCard = this.listContainer?.querySelector('.product-card');

        this.init();
    }

    init() {
        if (!this.listContainer || !this.prototypeCard) return;
        this.update();
        this.renderPagination();
    }

    // ===== Pagination logic =====
    get paginatedData() {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.products.slice(start, end);
    }

    get totalPages() {
        return Math.ceil(this.products.length / this.perPage);
    }

    goToPage(page) {
        this.currentPage = page;
        this.update();
        this.renderPagination();
    }

    next() {
        if (this.currentPage < this.totalPages) {
            this.currentPage++;
            this.update();
            this.renderPagination();
        }
    }

    prev() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.update();
            this.renderPagination();
        }
    }

    update() {
        this.renderProducts(this.paginatedData);
    }

    // ===== Render products =====
    renderProducts(productsToRender) {
        // nettoyage
        this.listContainer
            .querySelectorAll('.product-card:not([hidden])')
            .forEach(el => el.remove());

        productsToRender.forEach(product => {
            const clone = this.prototypeCard.cloneNode(true);
            clone.removeAttribute('hidden');

            Object.entries(product).forEach(([key, value]) => {
                if (value && typeof value === 'object' && !Array.isArray(value)) {
                    Object.entries(value).forEach(([k, v]) => {
                        const el = clone.querySelector(`[data-name="${k}"]`);
                        if (el) {
                            el.textContent = v;
                            el.setAttribute('data-value', v);
                        }
                    });
                    return;
                }

                const el = clone.querySelector(`[data-name="${key}"]`);
                if (!el) return;

                if (el.tagName.toLowerCase() === 'img') el.src = value;
                else {
                    el.textContent = value;
                    el.setAttribute('data-value', value);
                }
            });

            this.listContainer.appendChild(clone);
        });
    }

    // ===== Render pagination UI =====
    renderPagination() {
        if (!this.paginationContainer) return;

        this.paginationContainer.innerHTML = '';

        // prev
        const prevBtn = this.createButton('←', () => this.prev());
        prevBtn.disabled = this.currentPage === 1;
        this.paginationContainer.appendChild(prevBtn);

        // pages
        for (let i = 1; i <= this.totalPages; i++) {
            const btn = this.createButton(i, () => this.goToPage(i));
            if (i === this.currentPage) btn.classList.add('active');
            this.paginationContainer.appendChild(btn);
        }

        // next
        const nextBtn = this.createButton('→', () => this.next());
        nextBtn.disabled = this.currentPage === this.totalPages;
        this.paginationContainer.appendChild(nextBtn);
    }

    createButton(label, onClick) {
        const btn = document.createElement('button');
        btn.textContent = label;
        btn.addEventListener('click', onClick);
        return btn;
    }
}
