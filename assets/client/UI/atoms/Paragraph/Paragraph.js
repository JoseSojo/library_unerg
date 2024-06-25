import React from 'react';

const Paragraph = ({ paragraph, customClass }) => {

    return <p
        className={`${customClass}`}
    >
        {paragraph}
    </p>
}

export default Paragraph;

