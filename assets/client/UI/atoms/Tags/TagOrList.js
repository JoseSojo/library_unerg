import React from 'react';

export default function TagOrList({ tag, customClass=``, list }) {

    // modalLogic
    if(list) {
        return (
            <>
                {
                    list.map((item, i) => (
                        <span 
                            className="relative inline-block px-1 before:absolute before:-inset-0.5 before:block before:rounded before:bg-blue-500/80" 
                            key={`item-${item}-index-${i}`}
                        >
                            <span className='relative text-white text-xs font-semibold'>
                                {item}
                            </span>
                        </span>
                    ))
                }
            </>
        )
    }

    return (
        <span 
            className="relative inline-block px-1 before:absolute before:-inset-0.5 before:block before:rounded-[20px] before:bg-[#bae8e8]" 
            key={`item-${tag}-index-${i}`}
        >
            <span className='relative text-white text-xs font-semibold'>
                {tag}
            </span>
        </span>
    );
}
