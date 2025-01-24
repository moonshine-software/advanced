document.addEventListener("moonshine:init", () => {
    MoonShine.onCallback('spaMenu', function(data, messageType, component) {
        const el = component.$el
        const menu = el.closest('.menu')
        const current = el.closest('li')
        menu.querySelectorAll('li').forEach((li) => {
            li.classList.remove('_is-active')
            li.querySelector('a').removeAttribute('data-stop-async')
        })
        current.classList.add('_is-active')
        el.setAttribute('data-stop-async', true)

        const url = new URL(el.href)
        url.searchParams.delete('_fragment-load')

        history.pushState({}, '', url.href)
    })

    MoonShine.onCallback('asyncTabs', function(data, messageType, component) {
        const el = component.$el
        const container = el.closest('.async-tabs-container')

        container.querySelectorAll('a').forEach((a) => {
            a.classList.remove('_is-active')
            a.removeAttribute('data-stop-async')
        })

        el.classList.add('_is-active')
        el.setAttribute('data-stop-async', true)
    })
})

document.addEventListener('alpine:init', () => {
    Alpine.data('asyncTabs', () => ({
        init() {
            const t = this
            this.$nextTick(() => {
                t.$root.querySelector('.async-tabs-container a').click()
            })
        },
    }))

    Alpine.data('stepper', () => ({
        head: null,
        steps: [],
        heads: [],
        active: 1,
        activeHead: 1,
        container: 1,
        activeStep: 1,
        finishBlock: 1,
        finished: false,
        lock: false,
        lockWhenFinish: false,
        loaded: [],

        init() {
            this.lock = this.$root.dataset.lock
            this.lockWhenFinish = this.$root.dataset.lockWhenFinish
            this.active = parseInt(this.$root.dataset.current ?? this.active)

            this.head = this.$root.querySelector('.js-stepper-head-container')
            this.container = this.$root.querySelector('.js-stepper-content-container')
            this.finishBlock = this.$root.querySelector('.js-stepper-finish-content')
            this.heads = this.head.querySelectorAll('.js-stepper-head')
            this.steps = this.container.querySelectorAll('.js-stepper-content')

            if(this.active > this.steps.length) {
                this.finish()
            } else {
                this._change()
            }
        },
        current(index) {
            if(this.lock) {
                return
            }

            if(this.lockWhenFinish && this.finished) {
                return
            }

            this.active = index
            this._change()
        },
        next() {
            this.active++
            this._change()
        },
        prev() {
            this.active--
            this._change()
        },
        finish() {
            this.finished = true
            this.active++
            this._change()
            this.finishBlock.style.display = 'block'
        },
        // internal
        _change() {
            this.finishBlock.style.display = 'none'
            this.activeHead = this.head.querySelector(`.js-stepper-head-${this.active}`)
            this.activeStep = this.container.querySelector(`.js-stepper-content-${this.active}`)

            if(this.activeHead) {
                const selector = `.js-stepper-content-${this.active} .js-stepper-content-html`

                if(this.activeHead.dataset.asyncUrl && this.loaded[this.active] === undefined) {
                    let stopLoading = function (data, t) {
                        t.loading = false
                        t.loaded[t.active] = true
                    }

                    MoonShine.request(
                        this,
                        this.activeHead.dataset.asyncUrl,
                        'get',
                        {},
                        {},
                        {
                            events: this.activeHead.dataset.asyncEvents,
                            selector: selector,
                            beforeHandleResponse: stopLoading,
                            errorCallback: stopLoading,
                        },
                    )
                }

                if(this.activeHead.dataset.asyncFinishEvents) {
                    MoonShine.dispatchEvents(
                        this.activeHead.dataset.asyncFinishEvents,
                        '',
                        this
                    )
                }
            }

            this.steps.forEach((step) => step.style.display = 'none')
            this.heads.forEach((step, i) => {
                step.classList.remove('active')
                let defaultEl = step.querySelector('.js-stepper-head-state-default')
                step.querySelector('.js-stepper-head-state-active').style.display = 'none'
                defaultEl.style.display = 'block'
                defaultEl.classList.remove('js-stepper-head-state-done')

                if(i < this.active) {
                    defaultEl.classList.add('js-stepper-head-state-done')
                }
            })

            if(this.activeHead && this.activeStep) {
                this.activeStep.style.display = 'block'
                this.activeHead.classList.add('active')
                this.activeHead.querySelector(
                    '.js-stepper-head-state-active').style.display = 'block'
                this.activeHead.querySelector(
                    '.js-stepper-head-state-default').style.display = 'none'
            }
        },
    }))
})
