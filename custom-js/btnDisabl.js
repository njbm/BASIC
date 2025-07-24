/*

function disableSubmitButton(button) {
    if (!button) return;

    const name = button.getAttribute('name');
    const value = button.getAttribute('value');
    const form = button.closest('form');

    if (form && name) {
        let hiddenInput = form.querySelector(`input[type="hidden"][name="${name}"]`);
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = name;
            form.appendChild(hiddenInput);
        }
        hiddenInput.value = value;
    }

    // Disable and show spinner
    button.disabled = true;
    button.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        ${Lang?.loading || 'Loading...'}
    `;
}

document.addEventListener('DOMContentLoaded', function () {
    let lastClickedSubmitButton = null;

    document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('click', function (e) {
            lastClickedSubmitButton = e.currentTarget;
        });
    });

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (event) {
            if (form.hasAttribute('data-ajax')) return;

            let submitButton = lastClickedSubmitButton;
            if (!submitButton || submitButton.getAttribute('form') !== form.id) {
                submitButton = document.querySelector(`button[type="submit"][form="${form.id}"]`)
                    || form.querySelector('button[type="submit"]');
            }
            disableSubmitButton(submitButton);
            lastClickedSubmitButton = null;
        });
    });
});
*/


/*
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function (e) {
        if (form.hasAttribute('data-ajax')) return;
        const button = e.submitter;
        if (!button || button.disabled) return;

        disableSubmitButton(button);
    });
});

function disableSubmitButton(button) {
    button.disabled = true;
    button.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        ${Lang?.loading || 'Loading...'}
    `;
}
*/


document.querySelectorAll('form').forEach(form => {
    form._lastClickedSubmitButton = null;

    form.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('click', function () {
            form._lastClickedSubmitButton = this;
        });
    });

    form.addEventListener('submit', function (e) {
        if (form.hasAttribute('data-ajax')) return;

        const button = form._lastClickedSubmitButton;

        if (!button || button.disabled) return;

        const name = button.name;
        const value = button.value;

        if (name && value) {
            let hiddenInput = form.querySelector(`input[type="hidden"][name="${name}"]`);
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = name;
                form.appendChild(hiddenInput);
            }
            hiddenInput.value = value;
        }

        disableSubmitButton(button);

        form._lastClickedSubmitButton = null;
    });
});

function disableSubmitButton(button) {
    button.disabled = true;
    button.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        ${Lang?.loading || 'Loading...'}
    `;
}
