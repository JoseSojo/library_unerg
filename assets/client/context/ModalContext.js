import React, { createContext, useState, useContext, useEffect} from 'react';

const defaultValue = {
    close: () => {},
    open: () => {},
    work: null,
    setWork: () => {},
    modal: false,
}

export const ContextModal = createContext(defaultValue);

export const ProviderModal = ({ children }) => {
    const [modal, setModal] = useState(false);
    const [work, setWork] = useState(null);

    const handleClose = () => setModal(false);
    const handleShow = () => setModal(true);

    return (
        <ContextModal.Provider value={{
            close: handleClose,
            open: handleShow,
            work, setWork,
            modal
        }}>
            {children}
        </ContextModal.Provider>
    )
} 

export const useModal = () => useContext(ContextModal);
