package temps.android

import android.app.PendingIntent
import android.content.Intent
import android.content.IntentFilter
import android.nfc.NfcAdapter
import android.nfc.Tag
import android.nfc.tech.Ndef
import android.nfc.tech.NfcA
import android.os.Bundle
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity

class NfcActivity : AppCompatActivity(), NfcAdapter.ReaderCallback {

    private lateinit var nfcAdapter: NfcAdapter
    private lateinit var nfcTagContent: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_nfc)

        nfcTagContent = findViewById(R.id.nfcTagContent)

        nfcAdapter = NfcAdapter.getDefaultAdapter(this)

        if (nfcAdapter == null) {
            nfcTagContent.text = "NFC is not available on this device."
            return
        }

        val pendingIntent = PendingIntent.getActivity(
            this, 0, Intent(this, javaClass).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), PendingIntent.FLAG_UPDATE_CURRENT
        )
        val intentFilters = arrayOf<IntentFilter>()
        val techList = arrayOf(
            arrayOf(NfcA::class.java.name, Ndef::class.java.name)
        )

        nfcAdapter.enableForegroundDispatch(this, pendingIntent, intentFilters, techList)
    }

    override fun onResume() {
        super.onResume()
        nfcAdapter.enableReaderMode(this, this, NfcAdapter.FLAG_READER_NFC_A or NfcAdapter.FLAG_READER_NDEF, null)
    }

    override fun onPause() {
        super.onPause()
        nfcAdapter.disableReaderMode(this)
    }

    override fun onTagDiscovered(tag: Tag?) {
        runOnUiThread {
            tag?.let { nfcTagContent.text = parseNfcTag(it) }
        }
    }

    private fun parseNfcTag(tag: Tag): String {
        val sb = StringBuilder()
        for (tech in tag.techList) {
            sb.append(tech).append("\n")
        }

        val ndef = Ndef.get(tag)
        if (ndef != null) {
            try {
                ndef.connect()
                if (ndef.ndefMessage != null) {
                    sb.append(String(ndef.ndefMessage.records[0].payload)).append("\n")
                } else {
                    sb.append("Empty NDEF message")
                }
                ndef.close()
            } catch (e: Exception) {
                e.printStackTrace()
            }
        }
        return sb.toString()
    }

}