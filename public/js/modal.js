$(function () {
    if (window.sessionMessages) {
        const success = window.sessionMessages.success;
        const error = window.sessionMessages.error;

        if (success) {
            const successModal = new bootstrap.Modal($("#successModal")[0]);
            successModal.show();
        }

        if (error) {
            const errorModal = new bootstrap.Modal($("#errorModal")[0]);
            errorModal.show();
        }
    }
});
