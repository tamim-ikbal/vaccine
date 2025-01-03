import React, {useState} from 'react';
import VerifyCode from "@/Components/Verification/VerifyCode.jsx";
import SendCode from "@/Components/Verification/SendCode.jsx";

function Verification({nid, fieldName, fieldValue, onVerified}) {
    const [canSendCode, setCanSendCode] = useState(true)
    const [codeSent, setCodeSent] = useState(false)

    const onCodeSent = () => {
        setCodeSent(true)
        setCanSendCode(false)
    }

    const onCodeVerified = () => {
        onVerified(fieldName, fieldValue)
        setCodeSent(false)
        setCanSendCode(true)
    }

    return (
        <div className='flex flex-col gap-3'>
            {canSendCode &&
                <SendCode
                    nid={nid}
                    fieldName={fieldName}
                    fieldValue={fieldValue}
                    onCodeSent={onCodeSent}
                />}

            {codeSent &&
                <VerifyCode
                    nid={nid}
                    fieldName={fieldName}
                    fieldValue={fieldValue}
                    onCodeVerified={onCodeVerified}
                />}
        </div>
    );
}

export default Verification;
