import {forwardRef, useEffect, useImperativeHandle, useRef} from 'react';
import {Select} from "@headlessui/react";

export default forwardRef(function SelectInput(
    {type = 'text', className = '', isFocused = false, children, ...props},
    ref,
) {
    const localRef = useRef(null);

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }));

    useEffect(() => {
        if (isFocused) {
            localRef.current?.focus();
        }
    }, [isFocused]);

    return (
        <Select
            {...props}
            type={type}
            className={
                'rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 ' +
                className
            }
            ref={localRef}
            {children}
        />
    );
});
