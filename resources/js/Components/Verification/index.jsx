import React, {useState, useEffect} from 'react';
import VerifyCode from "@/Components/Verification/VerifyCode.jsx";
import SendCode from "@/Components/Verification/SendCode.jsx";

function Verification({nid, fieldName, fieldValue, onVerified}) {
    const [canSendCode, setCanSendCode] = useState(true)
    const [codeSent, setCodeSent] = useState(false)
    const [timeLeft, setTimeLeft] = useState(0);

    const onCodeSent = () => {
        setCodeSent(true)
        setCanSendCode(false)
        setTimeLeft(60);
    }

    const onCodeVerified = () => {
        onVerified(fieldName, fieldValue)
        setCodeSent(false)
        setCanSendCode(true)
    }

    useEffect(() => {
        let timer;
        if (timeLeft > 0) {
            timer = setInterval(() => {
                setTimeLeft((prev) => prev - 1);
            }, 1000);
        } else if (timeLeft <= 0) {
            setCanSendCode(true);
        }
        return () => clearInterval(timer);
    }, [timeLeft]);
    const formatTime = (seconds) => {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes}:${remainingSeconds.toString().padStart(2, "0")}`;
    };
    return (
        <div className='flex flex-col gap-3'>
            <div className='mb-3'>
                <span>Verify {fieldName.toUpperCase()}: {fieldValue}</span>
            </div>
            {codeSent &&
                <VerifyCode
                    nid={nid}
                    fieldName={fieldName}
                    fieldValue={fieldValue}
                    onCodeVerified={onCodeVerified}
                />}

            {canSendCode &&
                <SendCode
                    nid={nid}
                    fieldName={fieldName}
                    fieldValue={fieldValue}
                    onCodeSent={onCodeSent}
                />}
            {timeLeft > 0 && <div>
                Resend available in: <span>{formatTime(timeLeft)}</span>
            </div>}
        </div>
    );
}

export default Verification;
