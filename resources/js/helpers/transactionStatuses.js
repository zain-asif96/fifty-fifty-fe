export const transactionStatuses = {
    'transaction_initialized': 1,
    'pairing_pending': 2,
    'pairing_complete': 3,
    'payment_to_receiver_pending': 4,
    'payment_to_receiver_complete': 5,
    'payment_to_receiver_confirmed': 6,
    'payment_to_opposite_receiver_pending': 7,
    'payment_to_opposite_receiver_complete': 8,
    'transaction_completed': 10,
    'transaction_cancelled': 0,
};

export const oppositeTransactionStatuses = {
    'transaction_initialized': 1,
    'pairing_complete': 2,
    'payment_to_opposite_receiver_confirmed': 3,
    'payment_to_receiver_complete': 4,
    'payment_to_receiver_confirmed': 5,
    'transaction_completed': 6,
    'transaction_cancelled': 0,
}
