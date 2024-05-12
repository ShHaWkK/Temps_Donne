# modules/translation_management.py
from googletrans import Translator, LANGUAGES

class TranslationManager:
    def __init__(self):
        self.translator = Translator()

    def translate_message(self, message, target_lang):
        try:
            translation = self.translator.translate(message, dest=target_lang)
            return translation.text
        except Exception as e:
            print(f"Erreur de traduction: {e}")
            return message

    def get_available_languages(self):
        return {code: name.capitalize() for code, name in LANGUAGES.items()}
