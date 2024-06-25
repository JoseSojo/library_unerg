import React from 'react';

const LinkTo = ({ path=`#`, children, customClass }) => {

    return <a
        href={`path`}
        className={`${customClass}`}
    >
        {children}
    </a>
}

export default LinkTo;

